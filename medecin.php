<?php
require_once 'security.php';
requireRole ('medecin');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médecin - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Espace Médecin - Hôpital Medicare</h1>
        <p>Bienvenue,
             Dr. <?php echo e($_SESSION['prenom']); ?>  
            <?php echo e($_SESSION['nom']); ?></p>
        <p>Gérer les patients, consulter les dossiers médicaux, etc.</p>
        <!-- Ajouter des fonctionnalités médecin ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>
