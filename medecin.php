<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'medecin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médecin - Hôpital Medicare</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        p { color: #666; }
        a { color: #4CAF50; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Espace Médecin - Hôpital Medicare</h1>
        <p>Bienvenue, Dr. <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></p>
        <p>Gérer les patients, consulter les dossiers médicaux, etc.</p>
        <!-- Ajouter des fonctionnalités médecin ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>
