<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'comptable') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptable - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="container">
        <h1>Espace Comptable - Hôpital Medicare</h1>
        <p>Bienvenue, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?> (Comptable)</p>
        <p>Gérer la comptabilité, les factures, les paiements, etc.</p>
        <!-- Ajouter des fonctionnalités comptable ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
  <script src="main.js" defer></script>
</body>
</html>