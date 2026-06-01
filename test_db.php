<?php
require 'config.php';
try {
    $conn = get_db_connection();
    echo "Base de données OK\n";
    $result = $conn->query('SHOW TABLES');
    if ($result) {
        echo "Tables trouvées: ";
        while ($row = $result->fetch_row()) {
            echo $row[0] . " ";
        }
        echo "\n";
        
        // Check utilisateurs table structure
        $check = $conn->query('DESCRIBE utilisateurs');
        if ($check) {
            echo "\nStructure de utilisateurs:\n";
            while ($row = $check->fetch_assoc()) {
                echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
            }
        }
    } else {
        echo "Aucune table trouvée\n";
    }
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>
