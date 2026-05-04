<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="hospital-page">
        <header class="hospital-header">
            <div class="brand-block">
                <div class="logo">HÔPITAL <span>Medicare</span></div>
                <div class="emergency-pill">Urgences 24h</div>
            </div>
            <nav class="header-nav">
                <a href="#services">Services</a>
                <a href="#patients">Patients</a>
                <a href="#nous">Nous connaître</a>
                <a href="#contact">Contact</a>
            </nav>
            <div class="header-contact">
                <a href="tel:0146252000">01 46 25 20 00</a>
            </div>
        </header>

        <main class="hero-section">
            <div class="hero-copy">
                <p class="eyebrow">Votre santé, notre priorité</p>
                <h1>Un accompagnement médical humain et sécurisé</h1>
                <p>Profitez d’un parcours patient fluide avec la prise de rendez-vous en ligne, un accueil personnalisé et un accès simple à vos résultats.</p>
                <div class="hero-actions">
                    <button onclick="window.location.href='login.php'">Accéder à mon espace</button>
                    <a href="#services" class="ghost-button">Découvrir nos services</a>
                </div>
                <div class="hero-stats">
                    <div>
                        <strong>24/7</strong>
                        <span>Service urgences</span>
                    </div>
                    <div>
                        <strong>+200</strong>
                        <span>Professionnels de santé</span>
                    </div>
                    <div>
                        <strong>Plus de 50</strong>
                        <span>spécialités médicales</span>
                    </div>
                </div>
            </div>
            <aside class="hero-card">
                <div class="card-header">
                    <p>Patient ou visiteur ?</p>
                    <span>Accédez à vos démarches en un clic</span>
                </div>
                <ul>
                    <li><a href="#">Prendre rendez-vous</a></li>
                    <li><a href="#">Préparer mon hospitalisation</a></li>
                    <li><a href="#">Récupérer mes résultats</a></li>
                    <li><a href="#">Contacter un spécialiste</a></li>
                </ul>
            </aside>
        </main>

        <section id="services" class="services-section">
            <div class="section-header">
                <p>Nos services</p>
                <h2>Des soins complets pour chaque besoin</h2>
            </div>
            <div class="service-grid">
                <article class="service-card">
                    <h3>Cardiologie</h3>
                    <p>Suivi personnalisé pour votre cœur avec des spécialistes expérimentés.</p>
                </article>
                <article class="service-card">
                    <h3>Maternité</h3>
                    <p>Accompagnement complet avant, pendant et après la naissance.</p>
                </article>
                <article class="service-card">
                    <h3>Imagerie</h3>
                    <p>Examens rapides avec des équipements de pointe.</p>
                </article>
                <article class="service-card">
                    <h3>Consultations</h3>
                    <p>Des rendez-vous en ligne avec vos médecins et spécialistes.</p>
                </article>
            </div>
        </section>

        <section id="nous" class="info-section">
            <div class="info-card">
                <h3>Pourquoi nous choisir ?</h3>
                <p>Un accueil chaleureux, une prise en charge rapide et un suivi personnalisé à chaque étape.</p>
            </div>
            <div class="info-card">
                <h3>Accessibilité</h3>
                <p>Des services adaptés aux personnes à mobilité réduite et aux besoins spécifiques.</p>
            </div>
            <div class="info-card">
                <h3>Équipe médicale</h3>
                <p>Des professionnels qualifiés dans toutes les disciplines médicales.</p>
            </div>
        </section>

        <footer id="contact" class="hospital-footer">
            <div>
                <h3>Besoin d’aide ?</h3>
                <p>Appelez notre accueil ou connectez-vous pour gérer vos démarches en ligne.</p>
            </div>
            <a href="tel:0146252000" class="footer-button">01 46 25 20 00</a>
        </footer>
    </div>
</body>
</html></content>
<parameter name="filePath">c:\xampp\htdocs\Mon projet hopital\entree.php