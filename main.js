/* COMMENTAIRE AJOUTÉ : Ce fichier contient du code JavaScript du projet Hôpital Medicare. */
const HopitalSite = (() => {
  const themeKey = 'hopital_theme_mode';
  const sectionIds = ['rdv', 'expertises', 'news', 'espace-patient', 'contacts'];
  const tabDescriptions = {
    Consultation: 'Consultez nos spécialistes et planifiez un parcours de soin clair, rapide et rassurant.',
    Urgences: 'Notre service d’urgences est disponible 24h/24, pour chaque situation critique et prise en charge immédiate.',
    Examen: 'Accédez aux examens, imageries et bilans en ligne pour une préparation optimale de votre consultation.'
  };

// COMMENTAIRE : initialise toutes les interactions et animations front-end du site.
  function init() {
    document.body.classList.add('hopital-ui-ready');
    injectThemeStyles();
    initSmoothNavigation();
    initStickyHeader();
    initScrollReveal();
    initCounters();
    initTabHeroSwitcher();
    initSectionHighlight();
    initThemeSwitcher();
    initHeroParallax();
    initFormGlow();
    initPageTitlePulse();
    showWelcomeToast();
  }

// COMMENTAIRE : injecte dynamiquement les styles nécessaires au mode sombre et aux toasts.
  function injectThemeStyles() {
    const style = document.createElement('style');
    style.id = 'hopital-main-styles';
    style.textContent = `
      .hopital-ui-ready * {
        transition: transform 0.35s ease, opacity 0.5s ease, box-shadow 0.35s ease, background-color 0.35s ease, color 0.35s ease;
      }
      .hopital-reveal-hidden { opacity: 0; transform: translateY(28px) scale(0.98); }
      .hopital-reveal-visible { opacity: 1; transform: translateY(0) scale(1); }
      .hopital-sticky { position: sticky; top: 0; left: 0; right: 0; z-index: 999; box-shadow: 0 18px 80px rgba(0,0,0,0.14); backdrop-filter: blur(10px); }
      .hopital-theme-switcher {
        position: fixed; bottom: 20px; right: 20px; z-index: 9999; border: none; border-radius: 999px; padding: 12px 16px; background: #0d6efd; color: #fff; cursor: pointer; box-shadow: 0 18px 40px rgba(13,110,253,0.22);
        font-size: 14px; letter-spacing: 0.04em;
      }
      .hopital-theme-switcher:hover { transform: translateY(-2px); box-shadow: 0 24px 48px rgba(13,110,253,0.3); }
      .dark-mode { background: #08101a !important; color: #eef2fb !important; }
      .dark-mode a, .dark-mode .link, .dark-mode .btn { color: #e8eeff !important; }
      .dark-mode .header, .dark-mode .footer, .dark-mode .card, .dark-mode .hero, .dark-mode .modal {
        background: rgba(12, 20, 34, 0.95) !important; box-shadow: 0 18px 60px rgba(0,0,0,0.24) !important; color: #eef2fb !important;
      }
      .hopital-tab-active { background: #0d6efd !important; color: #fff !important; }
      .hopital-toast {
        position: fixed; left: 50%; bottom: 28px; transform: translateX(-50%) translateY(40px); background: rgba(15,23,42,0.96); color: #f8fbff; padding: 14px 20px; border-radius: 999px; box-shadow: 0 22px 56px rgba(0,0,0,0.28); opacity: 0; pointer-events: none; transition: opacity 0.35s ease, transform 0.35s ease;
      }
      .hopital-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
    `;
    document.head.appendChild(style);
  }

// COMMENTAIRE : active le défilement fluide pour les liens d’ancrage internes.
  function initSmoothNavigation() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', event => {
        const targetId = anchor.getAttribute('href').substring(1);
        const target = document.getElementById(targetId);
        if (target) {
          event.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          history.replaceState(null, '', `#${targetId}`);
        }
      });
    });
  }

// COMMENTAIRE : rend la barre de navigation collante lorsque l’utilisateur fait défiler la page.
  function initStickyHeader() {
    const header = document.querySelector('.header');
    if (!header) return;
    const observer = new IntersectionObserver(entries => {
      if (!entries[0].isIntersecting) {
        header.classList.add('hopital-sticky');
      } else {
        header.classList.remove('hopital-sticky');
      }
    }, { rootMargin: '-120px 0px 0px 0px' });
    observer.observe(document.documentElement);
  }

// COMMENTAIRE : anime l’apparition des sections visibles lors du défilement.
  function initScrollReveal() {
    const elements = [
      ...document.querySelectorAll('.hero, .card, .news-item, .expertises article, .footer-block, .rdv, .expertises, .news, .espace-patient')
    ];
    elements.forEach(el => {
      el.classList.add('hopital-reveal-hidden');
    });
    const revealObserver = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('hopital-reveal-visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.18 });
    elements.forEach(el => revealObserver.observe(el));
  }

// COMMENTAIRE : anime les compteurs numériques pour un effet visuel progressif.
  function initCounters() {
    const numbers = document.querySelectorAll('.stat-number');
    numbers.forEach(item => {
      const value = parseInt(item.textContent.replace(/[^\d+]/g, ''), 10) || 0;
      item.textContent = '0';
      let start = 0;
      const duration = 1600;
      const stepTime = Math.max(Math.floor(duration / (value || 1)), 20);
      const interval = setInterval(() => {
        start += Math.max(1, Math.ceil(value / (duration / stepTime)));
        if (start >= value) {
          item.textContent = item.textContent.includes('+') ? `${value}+` : `${value}`;
          clearInterval(interval);
          return;
        }
        item.textContent = `${start}`;
      }, stepTime);
    });
  }

// COMMENTAIRE : gère le changement de contenu de la bannière en fonction des onglets sélectionnés.
  function initTabHeroSwitcher() {
    const buttons = document.querySelectorAll('.rdv-types .tab');
    const heroDescription = document.querySelector('.hero p');
    if (!buttons.length || !heroDescription) return;
    buttons.forEach(button => {
      button.addEventListener('click', () => {
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        const label = button.textContent.trim();
        const description = tabDescriptions[label] || 'Choisissez un service pour découvrir nos priorités d’accompagnement.';
        heroDescription.textContent = description;
      });
    });
  }

// COMMENTAIRE : met en surbrillance le lien de navigation correspondant à la section actuelle.
  function initSectionHighlight() {
    const sections = sectionIds.map(id => document.getElementById(id)).filter(Boolean);
    const navLinks = Array.from(document.querySelectorAll('.main-nav a')); 
    if (!sections.length || !navLinks.length) return;
    const obs = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        const id = entry.target.id;
        const link = navLinks.find(a => a.getAttribute('href') === `#${id}` || a.getAttribute('href') === `${id}`);
        if (entry.isIntersecting && link) {
          navLinks.forEach(a => a.classList.remove('active'));
          link.classList.add('active');
        }
      });
    }, { threshold: 0.4 });
    sections.forEach(section => obs.observe(section));
  }

// COMMENTAIRE : crée un bouton pour basculer entre les modes clair et sombre.
  function initThemeSwitcher() {
    const button = document.createElement('button');
    button.className = 'hopital-theme-switcher';
    button.type = 'button';
    const currentTheme = localStorage.getItem(themeKey) || 'light';
    setTheme(currentTheme, button);
    button.addEventListener('click', () => {
      const nextTheme = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
      setTheme(nextTheme, button);
    });
    document.body.appendChild(button);
  }

// COMMENTAIRE : applique le thème choisi et enregistre la préférence dans localStorage.
  function setTheme(theme, button) {
    if (theme === 'dark') {
      document.body.classList.add('dark-mode');
      button.textContent = 'Mode sombre 🌙';
      button.title = 'Activer le mode clair';
    } else {
      document.body.classList.remove('dark-mode');
      button.textContent = 'Mode clair ☀️';
      button.title = 'Activer le mode sombre';
    }
    localStorage.setItem(themeKey, theme);
  }

// COMMENTAIRE : active un effet parallax léger sur le bloc hero au mouvement de la souris.
  function initHeroParallax() {
    const hero = document.querySelector('.hero');
    if (!hero) return;
    hero.style.perspective = '1100px';
    hero.addEventListener('mousemove', event => {
      const rect = hero.getBoundingClientRect();
// COMMENTAIRE : calcule la position horizontale normalisée de la souris pour l’effet parallax.
      const x = (event.clientX - rect.left) / rect.width - 0.5;
// COMMENTAIRE : calcule la position verticale normalisée de la souris pour l’effet parallax.
      const y = (event.clientY - rect.top) / rect.height - 0.5;
      hero.style.transform = `rotateX(${y * 4}deg) rotateY(${x * 4}deg)`;
      hero.style.transformStyle = 'preserve-3d';
    });
    hero.addEventListener('mouseleave', () => {
      hero.style.transform = 'rotateX(0deg) rotateY(0deg)';
    });
  }

// COMMENTAIRE : applique l’effet de surbrillance aux champs de formulaire au focus et vérifie la validité avant envoi.
  function initFormGlow() {
    document.querySelectorAll('form input, form select, form textarea').forEach(input => {
      input.addEventListener('focus', () => input.style.boxShadow = '0 0 30px rgba(13,110,253,0.24)');
      input.addEventListener('blur', () => input.style.boxShadow = 'none');
      input.addEventListener('input', () => {
        if (input.validity.valid) {
          input.style.borderColor = '#0d6efd';
        } else {
          input.style.borderColor = '';
        }
      });
    });
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault();
          showToast('Merci de remplir tous les champs obligatoires avant de continuer.', 'warning');
          form.querySelectorAll(':invalid').forEach(field => {
            field.style.borderColor = '#dc3545';
          });
        }
      });
    });
  }

// COMMENTAIRE : fait clignoter légèrement le titre de la page pour attirer l’attention.
  function initPageTitlePulse() {
    const title = document.title;
    let tick = 0;
    setInterval(() => {
      tick = tick ? 0 : 1;
      document.title = tick ? `✨ ${title}` : title;
    }, 8800);
  }

// COMMENTAIRE : affiche un toast de bienvenue informatif au chargement de la page.
  function showWelcomeToast() {
    const messages = [
      'Bienvenue à l’Hôpital Medicare — une expérience plus fluide vous attend.',
      'Découvrez une navigation plus vive, plus claire et plus interactive.',
      'Votre parcours de soin devient plus moderne grâce à notre nouvelle interface.'
    ];
    const toast = document.createElement('div');
    toast.className = 'hopital-toast';
    toast.textContent = messages[Math.floor(Math.random() * messages.length)];
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => toast.classList.remove('show'), 6200);
    setTimeout(() => toast.remove(), 7200);
  }

// COMMENTAIRE : affiche un message temporaire de notification à l’écran.
  function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = 'hopital-toast show';
    toast.textContent = message;
    toast.dataset.type = type;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.remove('show'), 4200);
    setTimeout(() => toast.remove(), 4700);
  }

  return { init };
})();

document.addEventListener('DOMContentLoaded', HopitalSite.init);
