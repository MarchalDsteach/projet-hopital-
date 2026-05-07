<?php
require_once 'security.php';

requireRole('patient');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Espace Patient - Hôpital Medicare</h1>
        <p>Bienvenue,
             <?php echo e($_SESSION['prenom']); ?>
             <?php echo e($_SESSION['nom']); ?> (Patient)</p>
        <p>Consultez vos rendez-vous, résultats, etc.</p>
        <!-- Ajouter des fonctionnalités patient ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>