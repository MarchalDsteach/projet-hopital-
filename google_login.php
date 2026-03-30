<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "hôpital");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion DB']);
    exit();
}

//  Vérification token Google
function verifyGoogleToken($token) {
    $client_id = '989221879491-ldu7ab5ikrsn0v737itkru6ek9m57bbk.apps.googleusercontent.com'; 

    $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $token;
    $response = @file_get_contents($url);
    if ($response === false) return false;

    $payload = json_decode($response, true);
    if (!$payload || isset($payload['error'])) return false;

    // Vérifications importantes
    if (!isset($payload['sub'])) return false;
    if ($payload['aud'] !== $client_id) return false;
    if (!isset($payload['email_verified']) || $payload['email_verified'] !== "true") return false;
    if (!isset($payload['iss']) || ($payload['iss'] !== 'accounts.google.com' && $payload['iss'] !== 'https://accounts.google.com')) return false;

    return $payload;
}

// Récupération des données envoyées depuis le front
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['token'])) {
    echo json_encode(['success' => false, 'message' => 'Token manquant']);
    exit();
}

// Vérification du token
$payload = verifyGoogleToken($data['token']);
if (!$payload || !isset($payload['email'])) {
    echo json_encode(['success' => false, 'message' => 'Token invalide']);
    exit();
}

// Récupération des infos Google
$email = $payload['email'];
$nom = $payload['family_name'] ?? '';
$prenom = $payload['given_name'] ?? '';
$google_id = $payload['sub'];

//  Vérifier si utilisateur existe
$stmt = $conn->prepare("SELECT id, role, google_id FROM utilisateurs WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Lier le compte à Google si nécessaire
    if (empty($user['google_id'])) {
        $update = $conn->prepare("UPDATE utilisateurs SET google_id = ? WHERE id = ?");
        $update->bind_param("si", $google_id, $user['id']);
        $update->execute();
    }

    // Création de la session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    session_regenerate_id(true);

    echo json_encode(['success' => true, 'role' => $user['role']]);
    exit();

} else {
    // Création automatique d’un utilisateur patient
    $role = "patient";
    $insert = $conn->prepare("INSERT INTO utilisateurs (email, nom, prenom, role, google_id) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("sssss", $email, $nom, $prenom, $role, $google_id);
    if (!$insert->execute()) {
        echo json_encode(['success' => false, 'message' => 'Erreur insertion utilisateur']);
        exit();
    }

    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['role'] = $role;
    session_regenerate_id(true);

    echo json_encode(['success' => true, 'role' => $role]);
    exit();
}

$conn->close();
?>