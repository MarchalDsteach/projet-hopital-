<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Plateforme hospitalière — Hôpital Medicare</title>
  <link rel="stylesheet" href="home.css">
</head>
<body>
  <header class="header">
    <div class="logo">Hôpital Medicare</div>
    <nav class="main-nav">
      <a href="home.php">Accueil</a>
      <a href="#expertises">Spécialités</a>
      <a href="#rdv">Prendre RDV</a>
      <a href="#espace-patient">Hospitalisation</a>
      <a href="#news">Recherche</a>
      <a href="#news">L'hôpital</a>
      <a href="login.php">Espace patient</a>
      <a href="#rdv">Urgences</a>
    </nav>
    <div class="badge">Établissement privé d'intérêt collectif</div>
  </header>

  <section class="hero">
    <h1>Des soins d'excellence à votre service</h1>
    <p>
      L'Hôpital Medicare, centre de référence en Île-de-France, vous accompagne dans chaque étape de votre
      parcours de soin, de la consultation à la chirurgie de pointe.
    </p>
    <div class="hero-actions">
      <a href="#rdv" class="btn primary">Prendre rendez-vous</a>
      <a href="#expertises" class="btn secondary">Découvrir nos services</a>
    </div>
    <div class="stats">
      <div class="stat">
        <span class="stat-number">950</span>
        <span class="stat-label">Lits et places</span>
      </div>
      <div class="stat">
        <span class="stat-number">45+</span>
        <span class="stat-label">Spécialités médicales</span>
      </div>
      <div class="stat">
        <span class="stat-number">3 200</span>
        <span class="stat-label">Professionnels de santé</span>
      </div>
    </div>
  </section>

  <section class="rdv" id="rdv">
    <h2>Prendre rendez-vous</h2>
    <div class="rdv-types">
      <button class="tab active">Consultation</button>
      <button class="tab">Urgences</button>
      <button class="tab">Examen</button>
    </div>
    <div class="rdv-urgences">
      <span class="badge-urgences">Urgences ouvertes 24h/24</span>
      <span class="urgences-phone">Tél. 01 46 25 20 00</span>
    </div>
    <form class="rdv-form">
      <div class="form-group">
        <label>Spécialité ou médecin</label>
        <input type="text" placeholder="Ex : Cardiologie, Dr Dupont">
      </div>
      <div class="form-group">
        <label>Date souhaitée</label>
        <input type="text" placeholder="jj / mm / aaaa">
      </div>
      <div class="form-group">
        <label>Type de consultation</label>
        <select>
          <option>Première consultation</option>
          <option>Suivi</option>
        </select>
      </div>
      <button type="submit" class="btn primary">Rechercher un créneau</button>
    </form>
    <div class="teleconsultation">
      <strong>🖥 Téléconsultation</strong>
      <p>Consultation vidéo sous 24h</p>
    </div>
  </section>

  <section class="expertises" id="expertises">
    <h2>Expertises médicales</h2>
    <p class="subtitle">Nos spécialités</p>
    <div class="cards">
      <article class="card">
        <h3>🫀 Cardiologie</h3>
        <p>Centre de référence en chirurgie cardiaque et rythmologie interventionnelle</p>
        <a href="#" class="link">Prendre RDV →</a>
      </article>
      <article class="card">
        <h3>🫁 Pneumologie</h3>
        <p>Traitement des maladies respiratoires, unité de transplantation pulmonaire</p>
        <a href="#" class="link">Prendre RDV →</a>
      </article>
      <article class="card">
        <h3>🧠 Neurologie</h3>
        <p>Prise en charge des AVC, épilepsie et maladies neurodégénératives</p>
        <a href="#" class="link">Prendre RDV →</a>
      </article>
      <article class="card">
        <h3>🦷 Cancérologie</h3>
        <p>Unité d'oncologie intégrative et essais cliniques de phase III</p>
        <a href="#" class="link">Prendre RDV →</a>
      </article>
      <article class="card">
        <h3>🦴 Orthopédie</h3>
        <p>Chirurgie prothétique, arthroscopie, rééducation fonctionnelle</p>
        <a href="#" class="link">Prendre RDV →</a>
      </article>
      <article class="card">
        <h3>👁 Ophtalmologie</h3>
        <p>Chirurgie réfractive au laser, glaucome, chirurgie de la cataracte</p>
        <a href="#" class="link">Prendre RDV →</a>
      </article>
      <article class="card">
        <h3>🍼 Maternité</h3>
        <p>Maternité niveau III, néonatologie et suivi périnatal personnalisé</p>
        <a href="#" class="link">Prendre RDV →</a>
      </article>
    </div>
    <div class="more-specialties">
      <span>+ 45 spécialités</span>
      <a href="#" class="link">Explorez l'ensemble de nos pôles médicaux et chirurgicaux →</a>
    </div>
  </section>

  <section class="news" id="news">
    <h2>Actualités</h2>
    <p class="subtitle">Vie de l'hôpital</p>
    <div class="news-list">
      <article class="news-item">
        <span class="tag innovation">Innovation</span>
        <h3>Premier robot chirurgical Da Vinci XI installé au bloc opératoire</h3>
        <p>Une avancée majeure pour la chirurgie mini-invasive au sein de l'hôpital Foch, permettant une précision accrue et une récupération plus rapide pour les patients.</p>
        <span class="date">12 avril 2026</span>
      </article>
      <article class="news-item">
        <span class="tag recherche">Recherche</span>
        <h3>Résultats prometteurs dans l'essai clinique sur la BPCO sévère</h3>
        <span class="date">5 avril 2026</span>
      </article>
      <article class="news-item">
        <span class="tag communique">Communiqué</span>
        <h3>Nouveau centre de transplantation hépatique — ouverture en mai</h3>
        <span class="date">28 mars 2026</span>
      </article>
      <article class="news-item">
        <span class="tag formation">Formation</span>
        <h3>L'hôpital Medicare accueille la 3ᵉ promotion de son Institut de formation infirmier</h3>
        <span class="date">20 mars 2026</span>
      </article>
    </div>
  </section>

  <section class="espace-patient" id="espace-patient">
    <h2>Votre espace patient en ligne</h2>
    <p>
      Gérez vos rendez-vous, accédez à vos résultats d'examens et communiquez avec votre équipe médicale
      depuis un espace sécurisé.
    </p>
    <ul class="features">
      <li>Résultats d'analyses en temps réel</li>
      <li>Ordonnances et comptes-rendus médicaux</li>
      <li>Messagerie sécurisée avec vos praticiens</li>
      <li>Facturation et remboursements</li>
    </ul>
    <a href="login.php" class="btn primary">Créer mon espace patient</a>

    <div class="espace-grid">
      <div class="espace-card">
        <h3>📅 Mes rendez-vous</h3>
        <p>Consulter, modifier ou annuler vos prochains RDV</p>
      </div>
      <div class="espace-card">
        <h3>🧾 Mes résultats</h3>
        <p>Bilans, imagerie et comptes-rendus en ligne</p>
      </div>
      <div class="espace-card">
        <h3>💬 Messagerie</h3>
        <p>Contacter votre équipe soignante en toute sécurité</p>
      </div>
      <div class="espace-card">
        <h3>💊 Ordonnances</h3>
        <p>Renouveler et télécharger vos prescriptions</p>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="footer-main">
      <div class="footer-block">
        <h3>Hôpital Foch</h3>
        <p>40 rue Worth, 92150 Suresnes</p>
        <p>Tél. 01 46 25 20 00</p>
        <p>FINESS : 920 018 072</p>
      </div>
      <div class="footer-block">
        <h4>Patients</h4>
        <ul>
          <li><a href="#">Prendre RDV</a></li>
          <li><a href="#">Espace patient</a></li>
          <li><a href="#">Préparer mon séjour</a></li>
          <li><a href="#">Droits des patients</a></li>
          <li><a href="#">Contacts et accès</a></li>
        </ul>
      </div>
      <div class="footer-block">
        <h4>Soins</h4>
        <ul>
          <li><a href="#">Urgences</a></li>
          <li><a href="#">Spécialités médicales</a></li>
          <li><a href="#">Chirurgie</a></li>
          <li><a href="#">Maternité</a></li>
          <li><a href="#">Consultations externes</a></li>
        </ul>
      </div>
      <div class="footer-block">
        <h4>Hôpital</h4>
        <ul>
          <li><a href="#">Présentation</a></li>
          <li><a href="#">Recherche clinique</a></li>
          <li><a href="#">Enseignement</a></li>
          <li><a href="#">Recrutement</a></li>
          <li><a href="#">Presse</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 Hôpital Foch — Établissement privé d'intérêt collectif</span>
      <span>HAS Certifié · APHP Partenaire · ISO 27001</span>
    </div>
  </footer>
</body>
</html>
