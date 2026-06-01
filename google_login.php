<?php
require_once 'config.php';
secure_session_start();
header('Content-Type: application/json');

try {
    $conn = get_db_connection();
} catch (RuntimeException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur interne.']);
    exit();
}

$adminEmails = ['admin@hopital-foch.org', 'engambejude@gmail.com'];
$adminEmailsLower = array_map('strtolower', $adminEmails);

function verifyGoogleToken(string $token) {
    $client_id = GOOGLE_CLIENT_ID;
    $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . rawurlencode($token);
    $response = @file_get_contents($url);
    if ($response === false) {
        return false;
    }

    $payload = json_decode($response, true);
    if (!$payload || isset($payload['error'])) {
        return false;
    }

    if (empty($payload['sub']) || empty($payload['email']) || empty($payload['aud']) || empty($payload['iss'])) {
        return false;
    }
    if ($payload['aud'] !== $client_id) {
        return false;
    }
    if ($payload['iss'] !== 'accounts.google.com' && $payload['iss'] !== 'https://accounts.google.com') {
        return false;
    }
    if (!isset($payload['email_verified']) || ($payload['email_verified'] !== 'true' && $payload['email_verified'] !== true)) {
        return false;
    }

    return $payload;
}

$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'] ?? '';
if (!is_string($token) || $token === '') {
    echo json_encode(['success' => false, 'message' => 'Token manquant.']);
    exit();
}

$payload = verifyGoogleToken($token);
if (!$payload || empty($payload['email'])) {
    echo json_encode(['success' => false, 'message' => 'Token invalide.']);
    exit();
}

$email = filter_var(trim(strtolower($payload['email'] ?? '')), FILTER_VALIDATE_EMAIL);
if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Adresse email invalide.']);
    exit();
}

$nom = trim($payload['family_name'] ?? '');
$prenom = trim($payload['given_name'] ?? '');
$google_id = trim($payload['sub'] ?? '');

if ($google_id === '') {
    echo json_encode(['success' => false, 'message' => 'Token invalide.']);
    exit();
}

$stmt = $conn->prepare('SELECT id, nom, prenom, role, google_id FROM utilisateurs WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (empty($user['google_id'])) {
        $update = $conn->prepare('UPDATE utilisateurs SET google_id = ? WHERE id = ?');
        $update->bind_param('si', $google_id, $user['id']);
        $update->execute();
        $update->close();
    }

    if (in_array(strtolower($email), $adminEmailsLower, true) && $user['role'] !== 'admin') {
        $user['role'] = 'admin';
        $updateRole = $conn->prepare('UPDATE utilisateurs SET role = ? WHERE id = ?');
        $updateRole->bind_param('si', $user['role'], $user['id']);
        $updateRole->execute();
        $updateRole->close();
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['prenom'] = $user['prenom'];
    session_regenerate_id(true);

    echo json_encode(['success' => true, 'role' => trim(strtolower($user['role']))]);
    exit();
}

$role = in_array($email, $adminEmailsLower, true) ? 'admin' : 'patient';
$insert = $conn->prepare('INSERT INTO utilisateurs (email, nom, prenom, role, google_id) VALUES (?, ?, ?, ?, ?)');
$insert->bind_param('sssss', $email, $nom, $prenom, $role, $google_id);
if (!$insert->execute()) {
    echo json_encode(['success' => false, 'message' => 'Erreur interne.']);
    exit();
}

$_SESSION['user_id'] = $conn->insert_id;
$_SESSION['role'] = $role;
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;
session_regenerate_id(true);

echo json_encode(['success' => true, 'role' => trim(strtolower($role))]);
$conn->close();
exit();
?>