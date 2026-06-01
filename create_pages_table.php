<?php
require_once 'config.php';

try {
    $conn = get_db_connection();
    
    $sql = "CREATE TABLE IF NOT EXISTS pages (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(100) NOT NULL,
        contenu LONGTEXT NOT NULL,
        ordre INT(3) NOT NULL DEFAULT 0,
        actif TINYINT(1) DEFAULT 1,
        date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY titre (titre)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql)) {
        echo "✅ Table 'pages' créée avec succès!<br>";
        
        // Insérer des pages par défaut
        $defaultPages = [
            ['Prendre RDV', 'Réservez votre rendez-vous en ligne. Notre équipe médicale est disponible pour vous accueillir.', 1],
            ['Espace patient', 'Gérez votre espace personnel, consultez vos rendez-vous et vos documents médicaux.', 2],
            ['Préparer mon séjour', 'Découvrez comment préparer votre séjour à l\'hôpital Medicare.', 3],
            ['Droits des patients', 'Connaître vos droits et obligations en tant que patient.', 4],
            ['Contacts et accès', 'Retrouvez tous nos coordonnées et nos horaires d\'ouverture.', 5],
            ['Urgences', 'En cas d\'urgence, contactez notre service 24h/24.', 6],
            ['Chirurgie', 'Nos services de chirurgie générale et spécialisée.', 7],
            ['Maternité', 'Bienvenue dans notre maternité. Un suivi de la grossesse jusqu\'après l\'accouchement.', 8],
            ['Consultations externes', 'Accédez à nos consultations spécialisées et généralistes.', 9],
            ['Présentation', 'Découvrez l\'histoire et les valeurs de l\'hôpital Medicare.', 10],
            ['Recherche clinique', 'Participez à nos programmes de recherche clinique.', 11],
            ['Enseignement', 'L\'hôpital accueille des étudiants en médecine et paramédicaux.', 12],
            ['Recrutement', 'Rejoignez notre équipe! Consultez nos offres d\'emploi.', 13],
            ['Presse', 'Retrouvez les dernières actualités de l\'hôpital Medicare.', 14],
        ];
        
        foreach ($defaultPages as $page) {
            $stmt = $conn->prepare('INSERT IGNORE INTO pages (titre, contenu, ordre) VALUES (?, ?, ?)');
            $stmt->bind_param('ssi', $page[0], $page[1], $page[2]);
            $stmt->execute();
            $stmt->close();
        }
        
        echo "✅ Pages par défaut insérées!<br>";
        echo "<a href='manage_content.php'>Gérer le contenu →</a>";
    } else {
        echo "❌ Erreur: " . $conn->error;
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}
?>
