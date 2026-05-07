<?php
require_once 'security.php';
requireRole('admin');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Mode Admin - Hôpital Medicare</h1>
        <p>Bienvenue, 
        <?php echo e($_SESSION['prenom']); ?>
        <?php echo e($_SESSION['nom']); ?>
            (Admin)
        </p>
        <p>Ici, vous pouvez gérer les utilisateurs, les rendez-vous, etc.</p>
        <!-- Ajouter des fonctionnalités admin ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>