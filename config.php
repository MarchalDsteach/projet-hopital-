<?php
/* COMMENTAIRE AJOUTÉ : Ce fichier contient du code PHP du projet Hôpital Medicare. */
// Configuration centrale de sécurité et de base de données
error_reporting(0);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hopital');

define('GOOGLE_CLIENT_ID', '989221879491-ldu7ab5ikrsn0v737itkru6ek9m57bbk.apps.googleusercontent.com');

define('ADMIN_EMAILS', serialize(['engambejude@gmail.com']));

define('SECURE_SESSION_NAME', 'hopital_session');

define('CSRF_TOKEN_KEY', 'csrf_token');

define('SESSION_INIT_KEY', 'session_initiated');

// COMMENTAIRE : envoie des en-têtes HTTP de sécurité (CSP, HSTS, X-Frame-Options, etc.).
function send_security_headers(): void {
    if (headers_sent()) {
        return;
    }

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: no-referrer-when-downgrade');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    header('X-XSS-Protection: 1; mode=block');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://accounts.google.com https://oauth2.googleapis.com; style-src 'self' 'unsafe-inline' https://accounts.google.com; connect-src 'self' https://oauth2.googleapis.com https://accounts.google.com; img-src 'self' data: https:; font-src 'self' https://fonts.googleapis.com; frame-src https://accounts.google.com;");

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
             (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    if ($https) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}

// COMMENTAIRE : vérifie la connexion et redirige vers HTTPS si nécessaire.
function enforce_https(): void {
    if (php_sapi_name() === 'cli' || !isset($_SERVER['HTTP_HOST'])) {
        return;
    }

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
             (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    if (!$https) {
        $isJsonApi = stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $isJsonApi || $isAjax) {
            return;
        }

        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $requestUri, true, 301);
        exit();
    }
}

// COMMENTAIRE : démarre une session sécurisée avec des cookies HttpOnly, Secure et SameSite.
function secure_session_start(): void {
    enforce_https();
    if (session_status() === PHP_SESSION_NONE) {
        $cookieSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                        (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

        session_name(SECURE_SESSION_NAME);
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'] ?? '',
            'secure' => $cookieSecure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        session_start();
        if (empty($_SESSION[SESSION_INIT_KEY])) {
            session_regenerate_id(true);
            $_SESSION[SESSION_INIT_KEY] = true;
        }
    }

    send_security_headers();
}

// COMMENTAIRE : crée une connexion MySQL et lance une exception en cas d’erreur.
function get_db_connection(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        error_log('DB Connection failed: ' . $conn->connect_error);
        throw new RuntimeException('Impossible de se connecter à la base de données.');
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

// COMMENTAIRE : échappe les caractères spéciaux pour une sortie HTML sûre.
function html_escape(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// COMMENTAIRE : normalise et valide une adresse email en la convertissant en minuscules.
function normalize_email(string $email): string {
    return filter_var(trim(strtolower($email)), FILTER_VALIDATE_EMAIL) ?: '';
}

// COMMENTAIRE : vérifie si l’email fait partie des adresses administratives autorisées.
function is_admin_email(string $email): bool {
    $email = normalize_email($email);
    $adminEmails = unserialize(ADMIN_EMAILS, ['allowed_classes' => false]) ?: [];
    return in_array($email, array_map('strtolower', $adminEmails), true);
}

// COMMENTAIRE : génère ou récupère un jeton CSRF sécurisé stocké en session.
function generate_csrf_token(): string {
    if (empty($_SESSION[CSRF_TOKEN_KEY])) {
        $_SESSION[CSRF_TOKEN_KEY] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_KEY];
}

// COMMENTAIRE : compare un jeton CSRF soumis au jeton stocké en session.
function verify_csrf_token(?string $token): bool {
    return is_string($token) && !empty($_SESSION[CSRF_TOKEN_KEY]) &&
           hash_equals($_SESSION[CSRF_TOKEN_KEY], $token);
}

// COMMENTAIRE : redirige de manière sûre en bloquant les URL contenant des retours chariot.
function safe_redirect(string $url): void {
    if (preg_match('/[\r\n]/', $url)) {
        return;
    }
    header('Location: ' . $url);
    exit();
}
