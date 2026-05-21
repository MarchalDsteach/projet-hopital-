<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Utilisateur par défaut de XAMPP
$password = ""; // Mot de passe vide par défaut
$dbname = "hopital"; // Remplacez par le nom de votre base de données

// Créer la connexion sans DB d'abord
$conn = new mysqli($servername, $username, $password);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Créer la base de données si elle n'existe pas
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
if ($conn->query($sql) === TRUE) {
    echo "Base de données créée ou déjà existante.<br>";
} else {
    echo "Erreur lors de la création de la base de données: " . $conn->error . "<br>";
}

// Se connecter à la base de données
$conn->select_db($dbname);

// Créer la table utilisateurs si elle n'existe pas
$sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'medecin', 'infirmiere', 'patient', 'technicien', 'autre', 'utilisateur', 'comptable', 'accueil') NOT NULL,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    google_id VARCHAR(255) UNIQUE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table utilisateurs créée ou déjà existante.<br>";
} else {
    echo "Erreur lors de la création de la table: " . $conn->error . "<br>";
}

// Mettre à jour la colonne role si nécessaire
$alter_sql = "ALTER TABLE utilisateurs MODIFY COLUMN role ENUM('admin', 'medecin', 'infirmiere', 'patient', 'technicien', 'autre', 'utilisateur', 'comptable', 'accueil') NOT NULL";
if ($conn->query($alter_sql) === TRUE) {
    echo "Colonne role mise à jour.<br>";
} else {
    echo "Erreur lors de la mise à jour de la colonne: " . $conn->error . "<br>";
}

// Ajouter la colonne google_id si elle n'existe pas
$alter_google_sql = "ALTER TABLE utilisateurs ADD COLUMN IF NOT EXISTS google_id VARCHAR(255) UNIQUE";
if ($conn->query($alter_google_sql) === TRUE) {
    echo "Colonne google_id ajoutée ou déjà existante.<br>";
} else {
    echo "Erreur lors de l'ajout de la colonne google_id: " . $conn->error . "<br>";
}

// Fermer la connexion
$conn->close();
?>