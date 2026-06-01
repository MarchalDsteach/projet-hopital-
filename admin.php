<?php
session_start();
//  pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

//  pas admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: patient.php");
    exit();
}
?>

<!DOCTYPE html>

<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administration — Hôpital Medicare</title>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin_hopital_medicare.css">
<link rel="stylesheet" href="global.css">
</head>
<body>

<!-- ════════════ SIDEBAR ════════════ -->

<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-mark">
      <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><rect x="11" y="5" width="2" height="9"/><rect x="7" y="10" width="10" height="2"/></svg>
    </div>
    <div class="sidebar-logo-text">
      <span>Hôpital Medicare</span>
      <span>Administration</span>
    </div>
  </div>

  <div class="sidebar-section">Tableau de bord</div>
  <a class="nav-item active" onclick="showPage('dashboard')">
    <span class="ni-icon">📊</span> Vue d'ensemble
  </a>
  <a class="nav-item" onclick="showPage('planning')">
    <span class="ni-icon">📅</span> Planning du jour
    <span class="nav-badge green">8</span>
  </a>

  <div class="sidebar-section">Gestion patients</div>
  <a class="nav-item" onclick="showPage('rdv')">
    <span class="ni-icon">🗓️</span> Rendez-vous
    <span class="nav-badge">3</span>
  </a>
  <a class="nav-item" onclick="showPage('patients')">
    <span class="ni-icon">👥</span> Dossiers patients
  </a>
  <a class="nav-item" onclick="showPage('urgences')">
    <span class="ni-icon">🚨</span> Urgences
    <span class="nav-badge">2</span>
  </a>

  <div class="sidebar-section">Hôpital</div>
  <a class="nav-item" onclick="showPage('medecins')">
    <span class="ni-icon">🩺</span> Médecins & Praticiens
  </a>
  <a class="nav-item" onclick="showPage('actualites')">
    <span class="ni-icon">📰</span> Actualités
  </a>
  <a class="nav-item" onclick="showPage('lits')">
    <span class="ni-icon">🛏️</span> Gestion des lits
  </a>

  <div class="sidebar-section">Système</div>
  <a class="nav-item" onclick="showPage('settings')">
    <span class="ni-icon">⚙️</span> Paramètres
  </a>

  <div class="sidebar-footer">
    <div class="admin-user">
      <div class="admin-avatar">AD</div>
      <div class="admin-user-info">
        <span>Administrateur</span>
        <span>Hôpital Medicare</span>
      </div>
    </div>
  </div>
</aside>

<!-- ════════════ MAIN ════════════ -->

<div class="main">

  <!-- TOP BAR -->

  <div class="topbar">
    <div class="topbar-left">
      <div class="topbar-breadcrumb" id="breadcrumb">Administration / Vue d'ensemble</div>
      <div class="topbar-title" id="page-title">Tableau de bord</div>
    </div>
    <div class="topbar-right">
      <button class="icon-btn" title="Notifications">🔔<span class="notif-dot"></span></button>
      <button class="icon-btn" title="Recherche globale">🔍</button>
      <button class="btn-primary" onclick="openModal('modal-rdv')">+ Nouveau RDV</button>
    </div>
  </div>

  <div class="content">


<!-- ═══ PAGE : DASHBOARD ═══ -->
<div class="page-view active" id="page-dashboard">

  <!-- Alertes -->
  <div class="alert-strip warning">⚠️ <strong>Capacité Urgences à 87%</strong> — Envisager la réorientation vers Foch Ouest</div>
  <div class="alert-strip info" style="margin-bottom:1.75rem">ℹ️ Maintenance système planifiée le <strong>10 mai 2026 de 2h à 4h</strong> — aucune interruption de service prévue</div>

  <!-- KPIs -->
  <div class="kpi-grid">
    <div class="kpi">
      <div class="kpi-header">
        <div class="kpi-label">RDV aujourd'hui</div>
        <div class="kpi-icon" style="background:var(--blue-light)">📅</div>
      </div>
      <div class="kpi-value">148</div>
      <div class="kpi-sub"><span class="trend up">+12%</span> vs hier</div>
    </div>
    <div class="kpi">
      <div class="kpi-header">
        <div class="kpi-label">Patients hospitalisés</div>
        <div class="kpi-icon" style="background:var(--teal-light)">🛏️</div>
      </div>
      <div class="kpi-value">732</div>
      <div class="kpi-sub"><span class="trend flat">~</span> taux d'occupation 77%</div>
    </div>
    <div class="kpi">
      <div class="kpi-header">
        <div class="kpi-label">Urgences (24h)</div>
        <div class="kpi-icon" style="background:#FCEAEA">🚨</div>
      </div>
      <div class="kpi-value">63</div>
      <div class="kpi-sub"><span class="trend down">+21%</span> vs semaine dernière</div>
    </div>
    <div class="kpi">
      <div class="kpi-header">
        <div class="kpi-label">Satisfaction patients</div>
        <div class="kpi-icon" style="background:var(--green-light)">⭐</div>
      </div>
      <div class="kpi-value">94<span style="font-size:16px;color:var(--muted)">%</span></div>
      <div class="kpi-sub"><span class="trend up">+2pts</span> ce mois</div>
    </div>
  </div>

  <div class="grid-2-1">

    <!-- Activité RDV -->
    <div class="card">
      <div class="card-header">
        <span class="section-h">Rendez-vous — 7 derniers jours</span>
        <div style="display:flex;gap:6px">
          <span style="display:flex;align-items:center;gap:4px;font-size:11.5px;color:var(--muted)"><span style="width:8px;height:8px;background:var(--blue);border-radius:2px;display:inline-block"></span>Consultations</span>
          <span style="display:flex;align-items:center;gap:4px;font-size:11.5px;color:var(--muted)"><span style="width:8px;height:8px;background:var(--teal);border-radius:2px;display:inline-block"></span>Urgences</span>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-placeholder">
          <div class="chart-bars">
            <div class="chart-bar" style="height:60%;background:var(--blue);opacity:.8"></div>
            <div class="chart-bar" style="height:20%;background:var(--teal);opacity:.8"></div>
            <div class="chart-bar" style="height:75%;background:var(--blue);opacity:.8"></div>
            <div class="chart-bar" style="height:25%;background:var(--teal);opacity:.8"></div>
            <div class="chart-bar" style="height:55%;background:var(--blue);opacity:.8"></div>
            <div class="chart-bar" style="height:18%;background:var(--teal);opacity:.8"></div>
            <div class="chart-bar" style="height:85%;background:var(--blue);opacity:.8"></div>
            <div class="chart-bar" style="height:30%;background:var(--teal);opacity:.8"></div>
            <div class="chart-bar" style="height:65%;background:var(--blue);opacity:.8"></div>
            <div class="chart-bar" style="height:22%;background:var(--teal);opacity:.8"></div>
            <div class="chart-bar" style="height:90%;background:var(--blue);opacity:.8"></div>
            <div class="chart-bar" style="height:28%;background:var(--teal);opacity:.8"></div>
            <div class="chart-bar" style="height:70%;background:var(--blue);opacity:.8"></div>
            <div class="chart-bar" style="height:35%;background:var(--teal);opacity:.8"></div>
          </div>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:11.5px;color:var(--muted);margin-top:6px">
          <span>01 mai</span><span>02 mai</span><span>03 mai</span><span>04 mai</span><span>05 mai</span><span>06 mai</span><span>07 mai</span>
        </div>
      </div>
    </div>

    <!-- Occupation par service -->
    <div class="card">
      <div class="card-header">
        <span class="section-h">Occupation par service</span>
      </div>
      <div class="card-body">
        <div class="stat-bar-item">
          <div class="stat-bar-label"><span>Cardiologie</span><span>94%</span></div>
          <div class="bar-track"><div class="bar-fill" style="width:94%;background:var(--accent)"></div></div>
        </div>
        <div class="stat-bar-item">
          <div class="stat-bar-label"><span>Pneumologie</span><span>87%</span></div>
          <div class="bar-track"><div class="bar-fill" style="width:87%;background:var(--orange)"></div></div>
        </div>
        <div class="stat-bar-item">
          <div class="stat-bar-label"><span>Neurologie</span><span>71%</span></div>
          <div class="bar-track"><div class="bar-fill" style="width:71%;background:var(--blue)"></div></div>
        </div>
        <div class="stat-bar-item">
          <div class="stat-bar-label"><span>Orthopédie</span><span>68%</span></div>
          <div class="bar-track"><div class="bar-fill" style="width:68%;background:var(--blue-mid)"></div></div>
        </div>
        <div class="stat-bar-item">
          <div class="stat-bar-label"><span>Maternité</span><span>55%</span></div>
          <div class="bar-track"><div class="bar-fill" style="width:55%;background:var(--teal)"></div></div>
        </div>
        <div class="stat-bar-item">
          <div class="stat-bar-label"><span>Oncologie</span><span>62%</span></div>
          <div class="bar-track"><div class="bar-fill" style="width:62%;background:var(--blue)"></div></div>
        </div>
      </div>
    </div>
  </div>

  <div class="grid-2">
    <!-- Derniers RDV -->
    <div class="card">
      <div class="card-header">
        <span class="section-h">Derniers rendez-vous</span>
        <button class="btn-sm" onclick="showPage('rdv')">Voir tout</button>
      </div>
      <div class="card-body" style="padding:0">
        <table>
          <thead><tr><th>Patient</th><th>Médecin</th><th>Spécialité</th><th>Statut</th></tr></thead>
          <tbody>
            <tr><td><strong>Dupont Marie</strong></td><td>Dr. Bernard</td><td>Cardiologie</td><td><span class="badge badge-green">Confirmé</span></td></tr>
            <tr><td><strong>Leroy Antoine</strong></td><td>Dr. Morel</td><td>Pneumologie</td><td><span class="badge badge-orange">En attente</span></td></tr>
            <tr><td><strong>Moreau Claire</strong></td><td>Dr. Petit</td><td>Neurologie</td><td><span class="badge badge-green">Confirmé</span></td></tr>
            <tr><td><strong>Lambert Paul</strong></td><td>Dr. Simon</td><td>Orthopédie</td><td><span class="badge badge-red">Annulé</span></td></tr>
            <tr><td><strong>Garcia Sofia</strong></td><td>Dr. Thomas</td><td>Ophtalmologie</td><td><span class="badge badge-blue">Téléconsult.</span></td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Activité récente -->
    <div class="card">
      <div class="card-header"><span class="section-h">Activité récente</span></div>
      <div class="card-body">
        <div class="activity-list">
          <div class="activity-item">
            <div class="act-icon" style="background:var(--green-light)">✅</div>
            <div class="act-body">
              <div class="act-text"><strong>Nouveau dossier patient</strong> créé — Leroy Antoine, Pneumologie</div>
              <div class="act-time">Il y a 8 min</div>
            </div>
          </div>
          <div class="activity-item">
            <div class="act-icon" style="background:#FCEAEA">🚨</div>
            <div class="act-body">
              <div class="act-text">Admission aux <strong>urgences</strong> — Garcia Élodie, traumatologie</div>
              <div class="act-time">Il y a 22 min</div>
            </div>
          </div>
          <div class="activity-item">
            <div class="act-icon" style="background:var(--blue-light)">📰</div>
            <div class="act-body">
              <div class="act-text">Actualité publiée — <strong>Ouverture du Centre Hépatique</strong></div>
              <div class="act-time">Il y a 1h</div>
            </div>
          </div>
          <div class="activity-item">
            <div class="act-icon" style="background:var(--orange-light)">⚠️</div>
            <div class="act-body">
              <div class="act-text">RDV annulé par le patient — <strong>Lambert Paul</strong> (Orthopédie)</div>
              <div class="act-time">Il y a 1h 30min</div>
            </div>
          </div>
          <div class="activity-item">
            <div class="act-icon" style="background:var(--teal-light)">🩺</div>
            <div class="act-body">
              <div class="act-text"><strong>Dr. Fontaine</strong> ajouté — Chirurgie thoracique</div>
              <div class="act-time">Il y a 3h</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- /dashboard -->

<!-- ═══ PAGE : PLANNING ═══ -->
<div class="page-view" id="page-planning">
  <div class="grid-2-1">
    <div class="card">
      <div class="card-header">
        <span class="section-h">Planning du 7 mai 2026</span>
        <div style="display:flex;gap:8px;align-items:center">
          <select class="filter-select">
            <option>Tous les services</option>
            <option>Cardiologie</option>
            <option>Pneumologie</option>
            <option>Neurologie</option>
          </select>
          <button class="btn-primary" style="font-size:12px;padding:6px 12px" onclick="openModal('modal-rdv')">+ RDV</button>
        </div>
      </div>
      <div class="card-body">
        <div class="slot-list">
          <div class="slot"><span class="slot-time">08h00</span><div class="slot-info"><div class="slot-name">Dupont Marie — Dr. Bernard</div><div class="slot-meta">Cardiologie · Consultation de suivi · Salle 104</div></div><span class="slot-dot dot-green"></span></div>
          <div class="slot"><span class="slot-time">08h30</span><div class="slot-info"><div class="slot-name">Roux Jean-Pierre — Dr. Morel</div><div class="slot-meta">Pneumologie · Première consultation · Salle 212</div></div><span class="slot-dot dot-green"></span></div>
          <div class="slot"><span class="slot-time">09h15</span><div class="slot-info"><div class="slot-name">Martin Isabelle — Dr. Petit</div><div class="slot-meta">Neurologie · Bilan IRM · Imagerie B</div></div><span class="slot-dot dot-blue"></span></div>
          <div class="slot"><span class="slot-time">10h00</span><div class="slot-info"><div class="slot-name">Fournier Luc — Dr. Simon</div><div class="slot-meta">Orthopédie · Post-op genou droit · Salle 310</div></div><span class="slot-dot dot-orange"></span></div>
          <div class="slot"><span class="slot-time">10h45</span><div class="slot-info"><div class="slot-name">Garcia Sofia — Dr. Thomas</div><div class="slot-meta">Ophtalmologie · Téléconsultation</div></div><span class="slot-dot dot-blue"></span></div>
          <div class="slot"><span class="slot-time">11h30</span><div class="slot-info"><div class="slot-name">Bernard Hélène — Dr. Fontaine</div><div class="slot-meta">Chirurgie thoracique · Pré-opératoire · Salle 105</div></div><span class="slot-dot dot-green"></span></div>
          <div class="slot"><span class="slot-time">14h00</span><div class="slot-info"><div class="slot-name">Leclerc Paul — Dr. Bernard</div><div class="slot-meta">Cardiologie · ECG & holter · Salle 104</div></div><span class="slot-dot dot-orange"></span></div>
          <div class="slot"><span class="slot-time">14h30</span><div class="slot-info"><div class="slot-name">Moreau Claire — Dr. Petit</div><div class="slot-meta">Neurologie · Consultation EEG · Salle 215</div></div><span class="slot-dot dot-green"></span></div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><span class="section-h">Mai 2026</span></div>
      <div class="card-body">
        <div class="cal-header">
          <div class="cal-title">Mai 2026</div>
          <div class="cal-nav">
            <button class="cal-btn">‹</button>
            <button class="cal-btn">›</button>
          </div>
        </div>
        <div class="cal-grid">
          <div class="cal-day-label">Lun</div><div class="cal-day-label">Mar</div><div class="cal-day-label">Mer</div><div class="cal-day-label">Jeu</div><div class="cal-day-label">Ven</div><div class="cal-day-label">Sam</div><div class="cal-day-label">Dim</div>
          <div class="cal-day other-month">28</div><div class="cal-day other-month">29</div><div class="cal-day other-month">30</div><div class="cal-day has-appt">1</div><div class="cal-day has-appt">2</div><div class="cal-day">3</div><div class="cal-day">4</div>
          <div class="cal-day has-appt">5</div><div class="cal-day has-appt">6</div><div class="cal-day today">7</div><div class="cal-day busy">8</div><div class="cal-day has-appt">9</div><div class="cal-day">10</div><div class="cal-day">11</div>
          <div class="cal-day has-appt">12</div><div class="cal-day has-appt">13</div><div class="cal-day has-appt">14</div><div class="cal-day">15</div><div class="cal-day has-appt">16</div><div class="cal-day">17</div><div class="cal-day">18</div>
          <div class="cal-day has-appt">19</div><div class="cal-day busy">20</div><div class="cal-day has-appt">21</div><div class="cal-day has-appt">22</div><div class="cal-day">23</div><div class="cal-day">24</div><div class="cal-day">25</div>
          <div class="cal-day has-appt">26</div><div class="cal-day has-appt">27</div><div class="cal-day has-appt">28</div><div class="cal-day has-appt">29</div><div class="cal-day has-appt">30</div><div class="cal-day">31</div><div class="cal-day other-month">1</div>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:1rem">
          <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;color:var(--muted)"><span style="width:8px;height:8px;border-radius:50%;background:var(--blue);display:inline-block"></span>RDV planifiés</span>
          <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;color:var(--muted)"><span style="width:8px;height:8px;border-radius:50%;background:var(--orange);display:inline-block"></span>Journée chargée</span>
          <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;color:var(--muted)"><span style="width:8px;height:8px;border-radius:50%;background:var(--blue);display:inline-block"></span>Aujourd'hui</span>
        </div>
      </div>
    </div>
  </div>
</div><!-- /planning -->

<!-- ═══ PAGE : RDV ═══ -->
<div class="page-view" id="page-rdv">
  <div class="card">
    <div class="card-header">
      <span class="section-h">Tous les rendez-vous</span>
      <button class="btn-primary" onclick="openModal('modal-rdv')">+ Nouveau RDV</button>
    </div>
    <div class="card-body">
      <div class="filter-row">
        <div class="search-input-wrap" style="flex:1;max-width:280px;margin-bottom:0">
          <span class="search-icon">🔍</span>
          <input type="text" placeholder="Chercher un patient ou médecin…">
        </div>
        <span class="filter-label">Filtrer :</span>
        <select class="filter-select"><option>Tous les statuts</option><option>Confirmé</option><option>En attente</option><option>Annulé</option></select>
        <select class="filter-select"><option>Toutes spécialités</option><option>Cardiologie</option><option>Pneumologie</option><option>Neurologie</option><option>Orthopédie</option></select>
        <select class="filter-select"><option>Aujourd'hui</option><option>Cette semaine</option><option>Ce mois</option></select>
      </div>
      <table>
        <thead><tr><th>Patient</th><th>Date & Heure</th><th>Médecin</th><th>Spécialité</th><th>Type</th><th>Statut</th><th>Actions</th></tr></thead>
        <tbody>
          <tr><td><strong>Dupont Marie</strong><br><span class="text-muted" style="font-size:11.5px">N° 00842</span></td><td>07/05/2026<br>08h00</td><td>Dr. Bernard</td><td>Cardiologie</td><td>Suivi</td><td><span class="badge badge-green">Confirmé</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>Leroy Antoine</strong><br><span class="text-muted" style="font-size:11.5px">N° 01203</span></td><td>07/05/2026<br>09h30</td><td>Dr. Morel</td><td>Pneumologie</td><td>1ère consult.</td><td><span class="badge badge-orange">En attente</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>Moreau Claire</strong><br><span class="text-muted" style="font-size:11.5px">N° 00391</span></td><td>07/05/2026<br>11h00</td><td>Dr. Petit</td><td>Neurologie</td><td>Suivi</td><td><span class="badge badge-green">Confirmé</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>Lambert Paul</strong><br><span class="text-muted" style="font-size:11.5px">N° 00654</span></td><td>07/05/2026<br>14h00</td><td>Dr. Simon</td><td>Orthopédie</td><td>Post-op</td><td><span class="badge badge-red">Annulé</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>Garcia Sofia</strong><br><span class="text-muted" style="font-size:11.5px">N° 00977</span></td><td>08/05/2026<br>10h15</td><td>Dr. Thomas</td><td>Ophtalmologie</td><td>Téléconsult.</td><td><span class="badge badge-blue">Téléconsult.</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>Roux Jean-Pierre</strong><br><span class="text-muted" style="font-size:11.5px">N° 01058</span></td><td>09/05/2026<br>08h30</td><td>Dr. Morel</td><td>Pneumologie</td><td>1ère consult.</td><td><span class="badge badge-orange">En attente</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
        </tbody>
      </table>
      <div class="pagination">
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">›</button>
      </div>
    </div>
  </div>
</div><!-- /rdv -->

<!-- ═══ PAGE : PATIENTS ═══ -->
<div class="page-view" id="page-patients">
  <div class="card">
    <div class="card-header">
      <span class="section-h">Dossiers patients</span>
      <button class="btn-primary" onclick="openModal('modal-patient')">+ Nouveau patient</button>
    </div>
    <div class="card-body">
      <div class="filter-row">
        <div class="search-input-wrap" style="flex:1;max-width:300px;margin-bottom:0">
          <span class="search-icon">🔍</span>
          <input type="text" placeholder="Nom, prénom, numéro de dossier…">
        </div>
        <select class="filter-select"><option>Tous les services</option><option>Cardiologie</option><option>Pneumologie</option></select>
      </div>
      <table>
        <thead><tr><th>N° Dossier</th><th>Patient</th><th>Date de naissance</th><th>Médecin référent</th><th>Dernier séjour</th><th>Statut</th><th>Actions</th></tr></thead>
        <tbody>
          <tr><td class="fw600 text-muted">00842</td><td><strong>Dupont Marie</strong></td><td>14/03/1968</td><td>Dr. Bernard</td><td>15 avr. 2026</td><td><span class="badge badge-green">Actif</span></td><td><button class="btn-sm">📋 Dossier</button></td></tr>
          <tr><td class="fw600 text-muted">01203</td><td><strong>Leroy Antoine</strong></td><td>07/08/1981</td><td>Dr. Morel</td><td>02 mai 2026</td><td><span class="badge badge-blue">Hospitalisé</span></td><td><button class="btn-sm">📋 Dossier</button></td></tr>
          <tr><td class="fw600 text-muted">00391</td><td><strong>Moreau Claire</strong></td><td>22/11/1975</td><td>Dr. Petit</td><td>10 jan. 2026</td><td><span class="badge badge-green">Actif</span></td><td><button class="btn-sm">📋 Dossier</button></td></tr>
          <tr><td class="fw600 text-muted">00654</td><td><strong>Lambert Paul</strong></td><td>30/06/1960</td><td>Dr. Simon</td><td>28 avr. 2026</td><td><span class="badge badge-muted">Inactif</span></td><td><button class="btn-sm">📋 Dossier</button></td></tr>
          <tr><td class="fw600 text-muted">00977</td><td><strong>Garcia Sofia</strong></td><td>12/05/1990</td><td>Dr. Thomas</td><td>06 mai 2026</td><td><span class="badge badge-green">Actif</span></td><td><button class="btn-sm">📋 Dossier</button></td></tr>
          <tr><td class="fw600 text-muted">01058</td><td><strong>Roux Jean-Pierre</strong></td><td>03/02/1955</td><td>Dr. Morel</td><td>—</td><td><span class="badge badge-orange">Nouveau</span></td><td><button class="btn-sm">📋 Dossier</button></td></tr>
        </tbody>
      </table>
      <div class="pagination">
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">›</button>
      </div>
    </div>
  </div>
</div><!-- /patients -->

<!-- ═══ PAGE : URGENCES ═══ -->
<div class="page-view" id="page-urgences">
  <div class="alert-strip error" style="margin-bottom:1.25rem">🚨 <strong>2 patients en attente critique</strong> — Intervention immédiate requise</div>
  <div class="kpi-grid" style="grid-template-columns:repeat(3,1fr)">
    <div class="kpi"><div class="kpi-header"><div class="kpi-label">En salle d'attente</div><div class="kpi-icon" style="background:#FCEAEA">⏳</div></div><div class="kpi-value">12</div><div class="kpi-sub">Temps moy. attente : <strong>38 min</strong></div></div>
    <div class="kpi"><div class="kpi-header"><div class="kpi-label">Cas critiques</div><div class="kpi-icon" style="background:#FCEAEA">🚨</div></div><div class="kpi-value">2</div><div class="kpi-sub"><span class="trend down">Priorité absolue</span></div></div>
    <div class="kpi"><div class="kpi-header"><div class="kpi-label">Capacité urgences</div><div class="kpi-icon" style="background:var(--orange-light)">📊</div></div><div class="kpi-value">87<span style="font-size:16px;color:var(--muted)">%</span></div><div class="kpi-sub"><span class="trend flat">Surveillance renforcée</span></div></div>
  </div>
  <div class="card">
    <div class="card-body" style="padding:0">
      <table>
        <thead><tr><th>Patient</th><th>Motif</th><th>Arrivée</th><th>Attente</th><th>Priorité</th><th>Praticien assigné</th><th>Statut</th></tr></thead>
        <tbody>
          <tr><td><strong>Garcia Élodie</strong></td><td>Traumatisme crânien</td><td>08h45</td><td>12 min</td><td><span class="badge badge-red">Critique</span></td><td>Dr. Petit</td><td><span class="badge badge-blue">En charge</span></td></tr>
          <tr><td><strong>Duval Marc</strong></td><td>Douleur thoracique</td><td>09h02</td><td>29 min</td><td><span class="badge badge-red">Critique</span></td><td>Dr. Bernard</td><td><span class="badge badge-orange">En attente</span></td></tr>
          <tr><td><strong>Lefèvre Camille</strong></td><td>Fracture cheville</td><td>09h15</td><td>42 min</td><td><span class="badge badge-orange">Urgent</span></td><td>—</td><td><span class="badge badge-orange">En attente</span></td></tr>
          <tr><td><strong>Noir Ahmed</strong></td><td>Fièvre 39.8°</td><td>09h30</td><td>57 min</td><td><span class="badge badge-muted">Standard</span></td><td>—</td><td><span class="badge badge-orange">En attente</span></td></tr>
          <tr><td><strong>Perrin Lucie</strong></td><td>Douleur abdominale</td><td>09h50</td><td>1h 17min</td><td><span class="badge badge-muted">Standard</span></td><td>—</td><td><span class="badge badge-orange">En attente</span></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div><!-- /urgences -->

<!-- ═══ PAGE : MÉDECINS ═══ -->
<div class="page-view" id="page-medecins">
  <div class="card">
    <div class="card-header">
      <span class="section-h">Médecins & Praticiens</span>
      <button class="btn-primary" onclick="openModal('modal-medecin')">+ Ajouter un praticien</button>
    </div>
    <div class="card-body">
      <div class="filter-row">
        <div class="search-input-wrap" style="flex:1;max-width:280px;margin-bottom:0">
          <span class="search-icon">🔍</span>
          <input type="text" placeholder="Nom ou spécialité…">
        </div>
        <select class="filter-select"><option>Toutes spécialités</option><option>Cardiologie</option><option>Pneumologie</option><option>Neurologie</option></select>
        <select class="filter-select"><option>Tous</option><option>Disponible</option><option>En consultation</option><option>Absent</option></select>
      </div>
      <table>
        <thead><tr><th>Praticien</th><th>Spécialité</th><th>Titre</th><th>RDV ce jour</th><th>Disponibilité</th><th>Actions</th></tr></thead>
        <tbody>
          <tr><td><strong>Dr. Bernard François</strong></td><td>Cardiologie</td><td>Chef de service</td><td>12 / 14</td><td><span class="badge badge-orange">En consultation</span></td><td><button class="btn-sm">✏️ Modifier</button></td></tr>
          <tr><td><strong>Dr. Morel Sophie</strong></td><td>Pneumologie</td><td>PH</td><td>8 / 10</td><td><span class="badge badge-green">Disponible</span></td><td><button class="btn-sm">✏️ Modifier</button></td></tr>
          <tr><td><strong>Dr. Petit Éric</strong></td><td>Neurologie</td><td>PH</td><td>6 / 8</td><td><span class="badge badge-green">Disponible</span></td><td><button class="btn-sm">✏️ Modifier</button></td></tr>
          <tr><td><strong>Dr. Simon Laure</strong></td><td>Orthopédie</td><td>PH</td><td>0 / 6</td><td><span class="badge badge-muted">Absent</span></td><td><button class="btn-sm">✏️ Modifier</button></td></tr>
          <tr><td><strong>Dr. Thomas Paul</strong></td><td>Ophtalmologie</td><td>Assistant</td><td>5 / 8</td><td><span class="badge badge-orange">En consultation</span></td><td><button class="btn-sm">✏️ Modifier</button></td></tr>
          <tr><td><strong>Dr. Fontaine Marie</strong></td><td>Chirurgie thoracique</td><td>PU-PH</td><td>4 / 6</td><td><span class="badge badge-green">Disponible</span></td><td><button class="btn-sm">✏️ Modifier</button></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div><!-- /medecins -->

<!-- ═══ PAGE : ACTUALITÉS ═══ -->
<div class="page-view" id="page-actualites">
  <div class="card">
    <div class="card-header">
      <span class="section-h">Gestion des actualités</span>
      <button class="btn-primary" onclick="openModal('modal-actu')">+ Publier une actualité</button>
    </div>
    <div class="card-body" style="padding:0">
      <table>
        <thead><tr><th>Titre</th><th>Catégorie</th><th>Date de publication</th><th>Statut</th><th>Actions</th></tr></thead>
        <tbody>
          <tr><td><strong>Premier robot chirurgical Da Vinci XI installé au bloc opératoire</strong></td><td><span class="badge badge-blue">Innovation</span></td><td>12 avril 2026</td><td><span class="badge badge-green">Publié</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>Résultats prometteurs dans l'essai clinique sur la BPCO sévère</strong></td><td><span class="badge" style="background:var(--teal-light);color:var(--teal)">Recherche</span></td><td>5 avril 2026</td><td><span class="badge badge-green">Publié</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>Nouveau centre de transplantation hépatique — ouverture en mai</strong></td><td><span class="badge badge-red">Communiqué</span></td><td>28 mars 2026</td><td><span class="badge badge-green">Publié</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>L'hôpital Foch accueille la 3ᵉ promotion de son Institut de formation infirmier</strong></td><td><span class="badge badge-blue">Formation</span></td><td>20 mars 2026</td><td><span class="badge badge-green">Publié</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>[Brouillon] Partenariat avec l'AP-HP pour la recherche en cancérologie</strong></td><td><span class="badge badge-muted">Recherche</span></td><td>—</td><td><span class="badge badge-muted">Brouillon</span></td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div><!-- /actualites -->

<!-- ═══ PAGE : LITS ═══ -->
<div class="page-view" id="page-lits">
  <div class="kpi-grid">
    <div class="kpi"><div class="kpi-header"><div class="kpi-label">Total lits</div><div class="kpi-icon" style="background:var(--blue-light)">🛏️</div></div><div class="kpi-value">950</div><div class="kpi-sub">Capacité totale</div></div>
    <div class="kpi"><div class="kpi-header"><div class="kpi-label">Lits occupés</div><div class="kpi-icon" style="background:#FCEAEA">🔴</div></div><div class="kpi-value">732</div><div class="kpi-sub"><span class="trend flat">77%</span> taux d'occupation</div></div>
    <div class="kpi"><div class="kpi-header"><div class="kpi-label">Lits disponibles</div><div class="kpi-icon" style="background:var(--green-light)">🟢</div></div><div class="kpi-value">218</div><div class="kpi-sub">Capacité restante</div></div>
    <div class="kpi"><div class="kpi-header"><div class="kpi-label">Sorties prévues</div><div class="kpi-icon" style="background:var(--orange-light)">🚪</div></div><div class="kpi-value">34</div><div class="kpi-sub">D'ici 18h aujourd'hui</div></div>
  </div>
  <div class="card">
    <div class="card-header"><span class="section-h">Occupation par service</span></div>
    <div class="card-body" style="padding:0">
      <table>
        <thead><tr><th>Service</th><th>Capacité</th><th>Occupés</th><th>Disponibles</th><th>Taux</th><th>Alertes</th></tr></thead>
        <tbody>
          <tr><td><strong>Cardiologie</strong></td><td>120</td><td>113</td><td>7</td><td><span class="badge badge-red">94%</span></td><td>⚠️ Quasi-plein</td></tr>
          <tr><td><strong>Pneumologie</strong></td><td>90</td><td>78</td><td>12</td><td><span class="badge badge-orange">87%</span></td><td>⚠️ Surveillance</td></tr>
          <tr><td><strong>Neurologie</strong></td><td>80</td><td>57</td><td>23</td><td><span class="badge badge-blue">71%</span></td><td>—</td></tr>
          <tr><td><strong>Orthopédie</strong></td><td>100</td><td>68</td><td>32</td><td><span class="badge badge-blue">68%</span></td><td>—</td></tr>
          <tr><td><strong>Oncologie</strong></td><td>110</td><td>68</td><td>42</td><td><span class="badge badge-green">62%</span></td><td>—</td></tr>
          <tr><td><strong>Maternité</strong></td><td>60</td><td>33</td><td>27</td><td><span class="badge badge-green">55%</span></td><td>—</td></tr>
          <tr><td><strong>Réanimation</strong></td><td>30</td><td>24</td><td>6</td><td><span class="badge badge-orange">80%</span></td><td>⚠️ Surveillance</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div><!-- /lits -->

<!-- ═══ PAGE : PARAMÈTRES ═══ -->
<div class="page-view" id="page-settings">
  <div class="grid-2">
    <div class="card">
      <div class="card-header"><span class="section-h">Informations générales</span></div>
      <div class="card-body">
        <div class="form-group"><label class="form-label">Nom de l'établissement</label><input class="form-input" value="Hôpital Foch"></div>
        <div class="form-group"><label class="form-label">Adresse</label><input class="form-input" value="40 rue Worth, 92150 Suresnes"></div>
        <div class="form-group"><label class="form-label">Téléphone principal</label><input class="form-input" value="01 46 25 20 00"></div>
        <div class="form-group"><label class="form-label">Email de contact</label><input class="form-input" value="contact@hopital-foch.org"></div>
        <div class="form-group"><label class="form-label">FINESS</label><input class="form-input" value="920 018 072"></div>
        <button class="btn-primary" style="margin-top:.5rem">Enregistrer</button>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><span class="section-h">Notifications & alertes</span></div>
      <div class="card-body">
        <div style="display:flex;flex-direction:column;gap:14px">
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border:1px solid var(--border);border-radius:7px">
            <div><div style="font-size:13.5px;font-weight:500">Alerte capacité urgences</div><div style="font-size:12px;color:var(--muted)">Notifier si taux > 80%</div></div>
            <div class="toggle-on" onclick="toggleSwitch(this)" style="width:36px;height:20px;background:var(--green);border-radius:10px;cursor:pointer;position:relative;flex-shrink:0"><div style="width:16px;height:16px;background:white;border-radius:50%;position:absolute;top:2px;right:2px;transition:all .2s"></div></div>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border:1px solid var(--border);border-radius:7px">
            <div><div style="font-size:13.5px;font-weight:500">RDV annulés en dernière minute</div><div style="font-size:12px;color:var(--muted)">Notification par email</div></div>
            <div class="toggle-on" onclick="toggleSwitch(this)" style="width:36px;height:20px;background:var(--green);border-radius:10px;cursor:pointer;position:relative;flex-shrink:0"><div style="width:16px;height:16px;background:white;border-radius:50%;position:absolute;top:2px;right:2px;transition:all .2s"></div></div>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border:1px solid var(--border);border-radius:7px">
            <div><div style="font-size:13.5px;font-weight:500">Rapport quotidien</div><div style="font-size:12px;color:var(--muted)">Envoi automatique à 18h</div></div>
            <div class="toggle-off" onclick="toggleSwitch(this)" style="width:36px;height:20px;background:#D8E4EE;border-radius:10px;cursor:pointer;position:relative;flex-shrink:0"><div style="width:16px;height:16px;background:white;border-radius:50%;position:absolute;top:2px;left:2px;transition:all .2s"></div></div>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border:1px solid var(--border);border-radius:7px">
            <div><div style="font-size:13.5px;font-weight:500">Alertes lits critiques</div><div style="font-size:12px;color:var(--muted)">Taux occupation > 90%</div></div>
            <div class="toggle-on" onclick="toggleSwitch(this)" style="width:36px;height:20px;background:var(--green);border-radius:10px;cursor:pointer;position:relative;flex-shrink:0"><div style="width:16px;height:16px;background:white;border-radius:50%;position:absolute;top:2px;right:2px;transition:all .2s"></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="section-h">Comptes administrateurs</span><button class="btn-primary" style="font-size:12px;padding:6px 12px">+ Ajouter un compte</button></div>
    <div class="card-body" style="padding:0">
      <table>
        <thead><tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Dernière connexion</th><th>Actions</th></tr></thead>
        <tbody>
          <tr><td><strong>Administrateur Principal</strong></td><td>admin@hopital-foch.org</td><td><span class="badge badge-red">Super Admin</span></td><td>Aujourd'hui 09h12</td><td><button class="btn-sm">✏️</button></td></tr>
          <tr><td><strong>Martin Delphine</strong></td><td>d.martin@hopital-foch.org</td><td><span class="badge badge-blue">Admin RDV</span></td><td>Hier 17h30</td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
          <tr><td><strong>Durand Olivier</strong></td><td>o.durand@hopital-foch.org</td><td><span class="badge badge-orange">Admin Contenu</span></td><td>06 mai 2026</td><td><button class="btn-sm">✏️</button><button class="btn-sm">🗑️</button></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div><!-- /settings -->


  </div><!-- /content -->
</div><!-- /main -->

<!-- ════════════ MODALS ════════════ -->

<!-- Modal : Nouveau RDV -->

<div class="modal-overlay" id="modal-rdv">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Créer un rendez-vous</div>
      <button class="modal-close" onclick="closeModal('modal-rdv')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Patient</label><input class="form-input" placeholder="Nom du patient"></div>
        <div class="form-group"><label class="form-label">N° Dossier</label><input class="form-input" placeholder="Ou créer un nouveau"></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Médecin</label><select class="form-input"><option>Dr. Bernard – Cardiologie</option><option>Dr. Morel – Pneumologie</option><option>Dr. Petit – Neurologie</option><option>Dr. Simon – Orthopédie</option><option>Dr. Thomas – Ophtalmologie</option></select></div>
        <div class="form-group"><label class="form-label">Type de consultation</label><select class="form-input"><option>Première consultation</option><option>Suivi médical</option><option>Téléconsultation</option><option>Post-opératoire</option></select></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Date</label><input class="form-input" type="date"></div>
        <div class="form-group"><label class="form-label">Heure</label><input class="form-input" type="time" value="09:00"></div>
      </div>
      <div class="form-group"><label class="form-label">Notes</label><textarea class="form-input" rows="3" placeholder="Informations complémentaires…" style="resize:vertical"></textarea></div>
    </div>
    <div class="modal-footer">
      <button class="btn-cancel" onclick="closeModal('modal-rdv')">Annuler</button>
      <button class="btn-primary">Confirmer le rendez-vous</button>
    </div>
  </div>
</div>

<!-- Modal : Nouveau patient -->

<div class="modal-overlay" id="modal-patient">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Nouveau dossier patient</div>
      <button class="modal-close" onclick="closeModal('modal-patient')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Nom</label><input class="form-input" placeholder="Nom de famille"></div>
        <div class="form-group"><label class="form-label">Prénom</label><input class="form-input" placeholder="Prénom"></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Date de naissance</label><input class="form-input" type="date"></div>
        <div class="form-group"><label class="form-label">N° Sécurité Sociale</label><input class="form-input" placeholder="1 85 05 75 115 …"></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Téléphone</label><input class="form-input" placeholder="06 …"></div>
        <div class="form-group"><label class="form-label">Email</label><input class="form-input" placeholder="email@domaine.fr"></div>
      </div>
      <div class="form-group"><label class="form-label">Médecin référent</label><select class="form-input"><option>— Choisir un praticien —</option><option>Dr. Bernard – Cardiologie</option><option>Dr. Morel – Pneumologie</option><option>Dr. Petit – Neurologie</option></select></div>
    </div>
    <div class="modal-footer">
      <button class="btn-cancel" onclick="closeModal('modal-patient')">Annuler</button>
      <button class="btn-primary">Créer le dossier</button>
    </div>
  </div>
</div>

<!-- Modal : Praticien -->

<div class="modal-overlay" id="modal-medecin">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Ajouter un praticien</div>
      <button class="modal-close" onclick="closeModal('modal-medecin')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Nom</label><input class="form-input" placeholder="Nom"></div>
        <div class="form-group"><label class="form-label">Prénom</label><input class="form-input" placeholder="Prénom"></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Spécialité</label><select class="form-input"><option>Cardiologie</option><option>Pneumologie</option><option>Neurologie</option><option>Orthopédie</option><option>Ophtalmologie</option><option>Chirurgie thoracique</option></select></div>
        <div class="form-group"><label class="form-label">Titre</label><select class="form-input"><option>PH</option><option>PU-PH</option><option>Assistant</option><option>Chef de service</option></select></div>
      </div>
      <div class="form-group"><label class="form-label">Email professionnel</label><input class="form-input" placeholder="prenom.nom@hopital-foch.org"></div>
      <div class="form-group"><label class="form-label">N° RPPS</label><input class="form-input" placeholder="10 chiffres"></div>
    </div>
    <div class="modal-footer">
      <button class="btn-cancel" onclick="closeModal('modal-medecin')">Annuler</button>
      <button class="btn-primary">Ajouter le praticien</button>
    </div>
  </div>
</div>

<!-- Modal : Actualité -->

<div class="modal-overlay" id="modal-actu">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Publier une actualité</div>
      <button class="modal-close" onclick="closeModal('modal-actu')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-group"><label class="form-label">Titre</label><input class="form-input" placeholder="Titre de l'actualité"></div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Catégorie</label><select class="form-input"><option>Innovation</option><option>Recherche</option><option>Communiqué</option><option>Formation</option></select></div>
        <div class="form-group"><label class="form-label">Date de publication</label><input class="form-input" type="date"></div>
      </div>
      <div class="form-group"><label class="form-label">Résumé</label><textarea class="form-input" rows="4" placeholder="Contenu de l'actualité…" style="resize:vertical"></textarea></div>
      <div class="form-group"><label class="form-label">Statut</label><select class="form-input"><option>Publier immédiatement</option><option>Sauvegarder en brouillon</option><option>Programmer</option></select></div>
    </div>
    <div class="modal-footer">
      <button class="btn-cancel" onclick="closeModal('modal-actu')">Annuler</button>
      <button class="btn-primary">Publier</button>
    </div>
  </div>
</div>

<script>
const pages = {
  dashboard:  { label:'Vue d\'ensemble',          crumb:'Administration / Vue d\'ensemble' },
  planning:   { label:'Planning du jour',          crumb:'Administration / Planning' },
  rdv:        { label:'Rendez-vous',               crumb:'Administration / Rendez-vous' },
  patients:   { label:'Dossiers patients',         crumb:'Administration / Patients' },
  urgences:   { label:'Urgences',                  crumb:'Administration / Urgences' },
  medecins:   { label:'Médecins & Praticiens',     crumb:'Administration / Médecins' },
  actualites: { label:'Gestion des actualités',    crumb:'Administration / Actualités' },
  lits:       { label:'Gestion des lits',          crumb:'Administration / Lits' },
  settings:   { label:'Paramètres',                crumb:'Administration / Paramètres' },
};

function showPage(id) {
  document.querySelectorAll('.page-view').forEach(p => p.classList.remove('active'));
  document.getElementById('page-' + id).classList.add('active');
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  event.currentTarget.classList.add('active');
  document.getElementById('page-title').textContent = pages[id].label;
  document.getElementById('breadcrumb').textContent = pages[id].crumb;
}

function openModal(id) {
  document.getElementById(id).classList.add('open');
}
function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
  });
});

function toggleSwitch(el) {
  const knob = el.querySelector('div');
  if (el.classList.contains('toggle-on')) {
    el.classList.replace('toggle-on','toggle-off');
    el.style.background = '#D8E4EE';
    knob.style.right = 'auto';
    knob.style.left = '2px';
  } else {
    el.classList.replace('toggle-off','toggle-on');
    el.style.background = 'var(--green)';
    knob.style.left = 'auto';
    knob.style.right = '2px';
  }
}
</script>
  <script src="main.js" defer></script>

</body>
</html>