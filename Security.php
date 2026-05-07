<?php
// security.php

ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// En local sans HTTPS, laisse secure à 0
ini_set('session.cookie_secure', 0);

session_start();

header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self';");

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function requireRole($role) {
    requireLogin();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        http_response_code(403);
        exit("Accès refusé");
    }
}