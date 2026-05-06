<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Hôpital Medicare</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue à l'Hôpital Medicare</h1>
        <p>Votre santé est notre priorité. Nous sommes là pour vous offrir un service médical de qualité et un accompagnement humain.</p>

        <div class="home-actions">
            <button onclick="window.location.href='login.php'">Se connecter</button>
            <button onclick="window.location.href='contact.php'">Contactez-nous</button>
        </div>

        <section class="home-features">
            <h2>Nos services</h2>
            <ul>
                <li>Consultations médicales</li>
                <li>Prise de rendez-vous rapide</li>
                <li>Accueil et orientation des patients</li>
                <li>Support administratif</li>
            </ul>
        </section>

        <section class="home-info">
            <h2>Accès rapide</h2>
            <p>Si vous êtes membre du personnel, utilisez votre espace dédié pour gérer les rendez-vous et les dossiers patients.</p>
        </section>
    </div>
</body>
</html>


<section class="hero">

  <div class="hero-left">
    <div class="hero-badge">
      Établissement privé d'intérêt collectif
    </div>

    <h1 class="hero-title">
      Des soins d'excellence à votre service
    </h1>

    <p class="hero-sub">
      L'Hôpital Foch vous accompagne dans chaque étape de votre parcours de soin.
    </p>

    <div class="hero-actions">
      <button class="btn-white">Prendre rendez-vous</button>
      <button class="btn-ghost">Découvrir</button>
    </div>

    <div class="hero-stats">
      <div class="hero-stat">
        <span>950</span>
        <span>Lits</span>
      </div>

      <div class="hero-stat">
        <span>45+</span>
        <span>Spécialités</span>
      </div>

      <div class="hero-stat">
        <span>3200</span>
        <span>Professionnels</span>
      </div>
    </div>
  </div>


  <div class="hero-right">

    <h3 class="hero-right-title">
      Prendre rendez-vous
    </h3>

    <div class="search-card">

      <div class="search-tabs">
        <button class="stab active">Consultation</button>
        <button class="stab">Urgences</button>
        <button class="stab">Examen</button>
      </div>

      <div class="search-body">

        <label class="field-label">
          Spécialité
        </label>

        <input class="field-input" type="text">

        <button class="btn-search">
          Rechercher
        </button>

      </div>

    </div>

  </div>

</section
</body>
</html>