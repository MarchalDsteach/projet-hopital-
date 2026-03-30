<?php
session_start();
//  pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

//  pas admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: patient.php");
    exit();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Hôpital Medicare</title>
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
        <h1>Mode Admin - Hôpital Medicare</h1>
        <p>Bienvenue, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?> (Admin)</p>
        <p>Ici, vous pouvez gérer les utilisateurs, les rendez-vous, etc.</p>
        <!-- Ajouter des fonctionnalités admin ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>