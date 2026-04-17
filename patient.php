<?php
session_start();
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// optionnel : forcer patient uniquement
if ($_SESSION['role'] !== 'patient') {
    header("Location: index.php");
    exit();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}
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
        <p>Bienvenue, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?> (Patient)</p>
        <p>Consultez vos rendez-vous, résultats, etc.</p>
        <!-- Ajouter des fonctionnalités patient ici -->
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>