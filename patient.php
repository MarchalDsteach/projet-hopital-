<?php
require_once 'config.php';
secure_session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    safe_redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon espace patient — Hôpital Medicare</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <header class="header">
        <div class="logo">Hôpital Medicare</div>
        <nav class="main-nav">
            <a href="home.php">Accueil</a>
            <a href="patient.php" class="active">Espace patient</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
        <div class="badge">Espace patient</div>
    </header>

    <section class="hero">
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?>.</h1>
        <p>Accédez à votre dossier médical, suivez vos rendez-vous et consultez vos résultats en toute sécurité.</p>
        <div class="hero-actions">
            <a href="#mes-rdv" class="btn primary">Mes rendez-vous</a>
            <a href="#mes-resultats" class="btn secondary">Mes résultats</a>
        </div>
        <div class="stats">
            <div class="stat">
                <span class="stat-number">3</span>
                <span class="stat-label">Rendez-vous à venir</span>
            </div>
            <div class="stat">
                <span class="stat-number">7</span>
                <span class="stat-label">Documents partagés</span>
            </div>
            <div class="stat">
                <span class="stat-number">100%</span>
                <span class="stat-label">Sécurité des données</span>
            </div>
        </div>
    </section>

    <section class="profile-overview">
        <article class="profile-card">
            <h3>Prochain rendez-vous</h3>
            <p>Consultation cardiologie le 28 mai 2026 à 14h00.</p>
        </article>
        <article class="profile-card">
            <h3>Dernier document</h3>
            <p>Compte-rendu radiologie disponible depuis le 18 mai 2026.</p>
        </article>
        <article class="profile-card">
            <h3>Messages</h3>
            <p>2 messages non lus de votre équipe médicale.</p>
        </article>
        <article class="profile-card">
            <h3>Ordonnance</h3>
            <p>Renouvellement disponible en ligne dès aujourd'hui.</p>
        </article>
    </section>

    <section class="expertises" id="mes-rdv">
        <h2>Mes rendez-vous</h2>
        <p class="subtitle">Planifiez et gérez vos consultations</p>
        <div class="cards">
            <article class="card">
                <h3>Consultation cardiologie</h3>
                <p>Le 28 mai 2026 à 14h00 avec le Dr Dupont</p>
            </article>
            <article class="card">
                <h3>Examen radiologie</h3>
                <p>Le 3 juin 2026 à 10h30, service imagerie</p>
            </article>
            <article class="card">
                <h3>Suivi infirmier</h3>
                <p>Le 12 juin 2026 à 09h00, prise de tension et bilan</p>
            </article>
        </div>
    </section>

    <section class="news" id="mes-resultats">
        <h2>Mes résultats</h2>
        <p class="subtitle">Accès rapide à vos bilans et documents</p>
        <div class="news-list">
            <article class="news-item">
                <h3>Examen sanguin</h3>
                <p>Disponible dans votre espace sécurisé.</p>
                <span class="date">22 mai 2026</span>
            </article>
            <article class="news-item">
                <h3>Compte-rendu radiologie</h3>
                <p>Téléchargeable depuis votre tableau de bord.</p>
                <span class="date">18 mai 2026</span>
            </article>
        </div>
    </section>

    <section class="espace-patient">
        <h2>Services disponibles</h2>
        <p>Voici les principaux services accessibles depuis votre espace patient.</p>
        <div class="espace-grid">
            <div class="espace-card">
                <h3>📅 Mes rendez-vous</h3>
                <p>Voir, modifier ou annuler mes rendez-vous.</p>
            </div>
            <div class="espace-card">
                <h3>🧾 Mes résultats</h3>
                <p>Consulter mes bilans et rapports médicaux.</p>
            </div>
            <div class="espace-card">
                <h3>💬 Messagerie</h3>
                <p>Échanger avec mon équipe médicale sécurisée.</p>
            </div>
            <div class="espace-card">
                <h3>💊 Ordonnances</h3>
                <p>Retrouver et télécharger mes prescriptions.</p>
            </div>
        </div>
    </section>

    <section class="contact-section" id="contacts">
        <h2>Contacts et support</h2>
        <p>Besoin d'aide ? Nos équipes sont là pour vous accompagner.</p>
        <div class="contact-grid">
            <div class="contact-card">
                <h3>Urgences</h3>
                <p>Tél. 01 46 25 20 00 — ouvert 24h/24</p>
            </div>
            <div class="contact-card">
                <h3>Accueil patient</h3>
                <p>accueil@hopital-medicare.fr</p>
            </div>
            <div class="contact-card">
                <h3>Assistance technique</h3>
                <p>support@hopital-medicare.fr</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-main">
            <div class="footer-block">
                <h3>Hôpital Medicare</h3>
                <p>40 rue Worth, 92150 Suresnes</p>
                <p>Tél. 01 46 25 20 00</p>
            </div>
            <div class="footer-block">
                <h4>Mon compte</h4>
                <ul>
                    <li><a href="patient.php">Mon profil</a></li>
                    <li><a href="patient.php#mes-rdv">Mes rendez-vous</a></li>
                    <li><a href="patient.php#mes-resultats">Mes résultats</a></li>
                </ul>
            </div>
            <div class="footer-block">
                <h4>Support</h4>
                <ul>
                    <li><a href="#contacts">Contacts et accès</a></li>
                    <li><a href="logout.php">Se déconnecter</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2026 Hôpital Medicare — Espace patient sécurisé</span>
            <span>Confidentialité et protection des données</span>
        </div>
    </footer>
  <script src="main.js" defer></script>
</body>
</html>
