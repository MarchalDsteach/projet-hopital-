<?php
/* COMMENTAIRE AJOUTÉ : Ce fichier contient du code PHP du projet Hôpital Medicare. */
$conn = new mysqli('localhost', 'root', '', 'hopital');
if ($conn->connect_error) {
    echo 'db fail: ' . $conn->connect_error;
    exit(1);
}
$res = $conn->query('SELECT id, email, role, google_id FROM utilisateurs');
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . ' | ' . $row['email'] . ' | ' . $row['role'] . ' | ' . $row['google_id'] . "\n";
}
$conn->close();
