<?php
/* COMMENTAIRE AJOUTÉ : Ce fichier contient du code PHP du projet Hôpital Medicare. */
require_once 'config.php';
secure_session_start();

$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'], $params['secure'], $params['httponly']
    );
}

session_destroy();
safe_redirect('login.php');
?>