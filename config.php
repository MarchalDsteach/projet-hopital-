<?php
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

function send_security_headers(): void {
    if (headers_sent()) {
        return;
    }

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: no-referrer-when-downgrade');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    header('X-XSS-Protection: 1; mode=block');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://accounts.google.com https://oauth2.googleapis.com; style-src 'self' 'unsafe-inline'; connect-src 'self' https://oauth2.googleapis.com; img-src 'self' data:; font-src 'self';");

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
             (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    if ($https) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}

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

function get_db_connection(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        error_log('DB Connection failed: ' . $conn->connect_error);
        throw new RuntimeException('Impossible de se connecter à la base de données.');
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

function html_escape(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function normalize_email(string $email): string {
    return filter_var(trim(strtolower($email)), FILTER_VALIDATE_EMAIL) ?: '';
}

function is_admin_email(string $email): bool {
    $email = normalize_email($email);
    $adminEmails = unserialize(ADMIN_EMAILS, ['allowed_classes' => false]) ?: [];
    return in_array($email, array_map('strtolower', $adminEmails), true);
}

function generate_csrf_token(): string {
    if (empty($_SESSION[CSRF_TOKEN_KEY])) {
        $_SESSION[CSRF_TOKEN_KEY] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_KEY];
}

function verify_csrf_token(?string $token): bool {
    return is_string($token) && !empty($_SESSION[CSRF_TOKEN_KEY]) &&
           hash_equals($_SESSION[CSRF_TOKEN_KEY], $token);
}

function safe_redirect(string $url): void {
    if (preg_match('/[\r\n]/', $url)) {
        return;
    }
    header('Location: ' . $url);
    exit();
}
