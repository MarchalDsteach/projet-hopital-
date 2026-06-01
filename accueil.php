<?php
/* COMMENTAIRE AJOUTÉ : Ce fichier contient du code PHP du projet Hôpital Medicare. */
require_once 'config.php';
secure_session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'accueil') {
    safe_redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="container">
        <h1>Espace Accueil - Hôpital Medicare</h1>
        <p>Bienvenue, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?> (Accueil)</p>
        <p>Gérer les admissions, les rendez-vous, les informations générales, etc. (Accès complet à la gestion de l'hôpital)</p>
        <!-- Ajouter des fonctionnalités accueil ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
  <script src="main.js" defer></script>
</body>
</html>