<?php
require_once 'security.php';

requireLogin();

if ($_SESSION['role'] !=='accueil') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Espace Accueil - Hôpital Medicare</h1>
        <p>Bienvenue, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?> (Accueil)</p>
        <p>Gérer les admissions, les rendez-vous, les informations générales, etc. (Accès complet à la gestion de l'hôpital)</p>
        <!-- Ajouter des fonctionnalités accueil ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>