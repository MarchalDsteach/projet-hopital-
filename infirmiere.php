<?php
/* COMMENTAIRE AJOUTÉ : Ce fichier contient du code PHP du projet Hôpital Medicare. */
require_once 'config.php';
secure_session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'infirmiere') {
    safe_redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infirmière - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="container">
        <h1>Espace Infirmière - Hôpital Medicare</h1>
        <p>Bienvenue, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?> (Infirmière)</p>
        <p>Gérer les soins aux patients, suivre les traitements, etc.</p>
        <!-- Ajouter des fonctionnalités infirmière ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
  <script src="main.js" defer></script>
</body>
</html>
