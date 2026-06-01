<?php
/* COMMENTAIRE AJOUTÉ : Ce fichier contient du code PHP du projet Hôpital Medicare. */
// Charger la configuration de la base de données et les fonctions de connexion
// COMMENTAIRE : inclusion de config.php pour charger les constantes, la sécurité et les utilitaires partagés.
require_once 'config.php';

// COMMENTAIRE : ouverture du bloc try/catch pour capturer les exceptions et afficher un message convivial.
try {
    // Établir une connexion à la base de données
    $conn = get_db_connection();
    
    // Définir le contenu des pages à mettre à jour dans la table "pages"
    $pagesData = [
        [
            'titre' => 'Prendre RDV',
            'contenu' => "RÉSERVEZ VOTRE RENDEZ-VOUS EN LIGNE

Bienvenue sur notre plateforme de réservation en ligne. Réservez votre consultation médicale en quelques clics seulement.

✅ POURQUOI PRENDRE RENDEZ-VOUS EN LIGNE?
• Gain de temps : plus besoin d'appeler
• Disponibilité 24h/24 : réservez quand vous le souhaitez
• Confirmation immédiate par email et SMS
• Rappel automatique avant votre consultation

📅 COMMENT RÉSERVER?
1. Sélectionnez la spécialité souhaitée (cardiologie, chirurgie, pédiatrie, etc.)
2. Choisissez un médecin disponible
3. Sélectionnez la date et l'heure qui vous convient
4. Confirmez votre rendez-vous
5. Recevez un email de confirmation

🏥 SPÉCIALITÉS DISPONIBLES
• Cardiologie
• Chirurgie générale
• Gynécologie et obstétrique
• Pédiatrie
• Pneumologie
• Gastro-entérologie
• Orthopédie
• Dermatologie

⏰ HORAIRES DE CONSULTATION
Lundi - Vendredi: 08h00 - 19h00
Samedi: 08h00 - 13h00
Dimanche: Urgences uniquement

📞 BESOIN D'AIDE?
Notre équipe est disponible pour vous aider:
- Téléphone: +212 5 XX XX XX XX
- Email: rdv@hopital-medicare.ma
- Chat en ligne disponible 24h/24"
        ],
        [
            'titre' => 'Espace patient',
            'contenu' => "GÉREZ VOTRE ESPACE PERSONNEL

Bienvenue dans votre espace sécurisé où vous pouvez accéder à tous vos dossiers médicaux.

👤 MON PROFIL
• Vérifier et mettre à jour vos informations personnelles
• Gérer vos préférences de communication
• Modifier votre mot de passe
• Activer l'authentification à deux facteurs

📋 MES RENDEZ-VOUS
• Consulter tous vos rendez-vous à venir
• Annuler ou reporter un rendez-vous (jusqu'à 48h avant)
• Recevoir des rappels par email/SMS
• Télécharger votre convocation

📄 MES DOCUMENTS
• Accéder à vos résultats d'analyses
• Consulter vos radiographies et imagerie
• Télécharger vos ordonnances
• Partager vos documents avec d'autres médecins

💊 MES TRAITEMENTS
• Suivi de vos prescriptions actuelles
• Historique complet de vos traitements
• Renouvellement d'ordonnance en ligne
• Alertes de contre-indications

📞 COMMUNICER AVEC VOTRE MÉDECIN
• Envoyer des messages à votre médecin
• Recevoir des conseils médicaux
• Accéder aux appels vidéo en consultation
• Temps de réponse moyen: 24-48h

🔒 SÉCURITÉ DE VOS DONNÉES
Tous vos dossiers sont protégés par:
• Chiffrement de bout en bout
• Authentification sécurisée
• Accès contrôlé à votre historique
• Conformité RGPD complète"
        ],
        [
            'titre' => 'Préparer mon séjour',
            'contenu' => "PRÉPAREZ VOTRE SÉJOUR À L'HÔPITAL

Un guide complet pour préparer votre admission et séjour à l'hôpital Medicare.

📋 AVANT VOTRE ADMISSION
• Apportez votre carte d'identité et votre carte de sécurité sociale
• Préparez la liste de vos traitements actuels
• Notez les allergies et intolérance aux médicaments
• Complétez le questionnaire médical en ligne
• Confirmez votre rendez-vous 48h avant

🎒 QUE FAUT-IL APPORTER?
À apporter:
✓ Pièce d'identité
✓ Carte de sécurité sociale
✓ Ordonnances et résultats médicaux
✓ Vêtements confortables et de rechange
✓ Articles de toilette personnels
✓ Chaussures fermées

À ne pas apporter:
✗ Objets de valeur
✗ Médicaments personnels (sauf accord du médecin)
✗ Appareils électroniques encombrants

🏥 À VOTRE ARRIVÉE
1. Vérification à l'accueil (10-15 min)
2. Installation dans votre chambre
3. Visite de l'infirmière
4. Examen médical préadmission
5. Signature des documents de consentement

🍽️ REPAS ET RESTAURATION
• Petit-déjeuner: 07h30 - 08h30
• Déjeuner: 12h00 - 13h00
• Dîner: 19h00 - 20h00
• Menus diététiques disponibles

👨‍⚕️ VISITE MÉDICALE
• Visite quotidienne de votre médecin: 09h00 - 11h00
• Les visiteurs sont autorisés: 14h00 - 20h00
• Maximum 2 visiteurs par jour

📞 NOTRE ÉQUIPE À VOTRE SERVICE
N'hésitez pas à appeler l'infirmière si besoin:
- Sonnette d'appel dans chaque chambre
- Infirmière disponible 24h/24"
        ],
        [
            'titre' => 'Droits des patients',
            'contenu' => "VOS DROITS EN TANT QUE PATIENT

Vous avez des droits fondamentaux que nous nous engageons à respecter.

⚖️ DROITS FONDAMENTAUX
• Droit d'accès à vos données médicales
• Droit à la confidentialité
• Droit au consentement éclairé
• Droit de refuser un traitement
• Droit d'être informé dans une langue compréhensible
• Droit à une seconde opinion médicale

🛡️ DROIT À LA SÉCURITÉ
• Traitement dans un environnement sûr et hygiénique
• Protection contre les infections hospitalières
• Signalement des incidents et événements indésirables
• Compensation en cas de dommages

📞 DROIT À L'INFORMATION
Vous avez le droit à:
• Des explications claires sur votre diagnostic
• Les options de traitement disponibles
• Les bénéfices et risques de chaque traitement
• Les coûts estimés de votre séjour

💼 DROIT À LA PROTECTION
• Absence de discrimination
• Protection contre les abus
• Aide aux personnes en situation de vulnérabilité
• Accès gratuit à un interprète si besoin

📋 DEVOIRS DU PATIENT
• Fournir des informations exactes sur votre santé
• Respecter les règles de l'hôpital
• Participer activement à votre traitement
• Respecter les autres patients et le personnel

⚠️ RÉCLAMATIONS ET PLAINTES
Vous pouvez déposer une réclamation si:
• Vous êtes insatisfait du service
• Vous pensez avoir été victime de négligence
• Vos droits ont été violés

Processus de réclamation:
1. Contactez le service des plaintes en personne ou par écrit
2. Fournissez les détails de votre plainte
3. Enquête interne menée sous 48-72h
4. Réponse écrite communiquée sous 7-10 jours
5. Droit d'appel auprès de l'instance de régulation

📞 CONTACT - DÉFENSEUR DES DROITS
Pour toute question sur vos droits:
Email: droits@hopital-medicare.ma
Téléphone: +212 5 XX XX XX XX
Permanence: Lundi - Vendredi 09h00 - 17h00"
        ],
        [
            'titre' => 'Contacts et accès',
            'contenu' => "RETROUVEZ-NOUS FACILEMENT

Tous nos coordonnées et nos horaires d'ouverture.

🏥 ADRESSE PRINCIPALE
Hôpital Medicare
Route de la Santé
21000 Doukkala, Maroc

📍 LOCALISATION GPS
Latitude: 33.2832°N
Longitude: -8.0000°W

🚗 ACCÈS EN VOITURE
Parking gratuit disponible:
• Parking principal: 500 places
• Parking handicapé: 30 places (gratuit)
• Accès facile depuis l'autoroute

🚌 TRANSPORTS EN COMMUN
• Bus ligne 12: arrêt 'Hôpital Medicare'
• Tramway T2: arrêt 'Santé'
• Gare SNCF: 15 km (taxi ou navette disponible)

⏰ HORAIRES D'OUVERTURE
Urgences: 24h/24 - 7j/7
Consultations externes: Lun-Ven 08h00-19h00, Sam 08h00-13h00
Hospitalisation: Admission 24h/24
Pharmacie: Lun-Ven 08h00-20h00, Sam 09h00-17h00

📞 NOUS CONTACTER
Standard: +212 5 XX XX XX XX
Urgences: +212 5 XX XX XX XX (prioritaire)
Rendez-vous: +212 5 XX XX XX XX
Email: contact@hopital-medicare.ma
Chat en ligne: www.hopital-medicare.ma/chat

🏢 SERVICES PAR ÉTAGE
Rez-de-chaussée: Accueil, Urgences, Pharmacie
1er étage: Cardiologie, Pneumologie
2e étage: Chirurgie, Orthopédie
3e étage: Maternité, Pédiatrie
4e étage: Gastro-entérologie, Dermatologie

👨‍💼 DIRECTION
Directeur Général: Dr Mohamed Ahmed
Email: direction@hopital-medicare.ma

📧 FORMULAIRES EN LIGNE
• Demande de dossier médical
• Demande d'accès aux données
• Réclamation ou plainte
• Suggestion d'amélioration"
        ],
        [
            'titre' => 'Urgences',
            'contenu' => "SERVICE D'URGENCES 24H/24

En cas d'urgence médicale, notre équipe est toujours disponible.

🚨 EN CAS D'URGENCE VITALE
Appelez immédiatement le SAMU: 15
Décrivez votre situation et suivez les consignes de l'opérateur.

🏥 NOTRE SERVICE D'URGENCES
Notre équipe multidisciplinaire comprend:
• Médecins urgentistes
• Infirmiers spécialisés
• Techniciens de radiologie
• Chirurgiens d'urgence
• Anesthésistes

⏱️ DÉLAI DE PRISE EN CHARGE
• Triage immédiat à l'arrivée
• Évaluation médicale sous 15 minutes
• Traitement en fonction de la gravité
• Possibilité d'hospitalisation d'urgence

📋 TRIAGE DES URGENCES
Niveau 1 (ROUGE - Urgence vitale):
Perte de conscience, arrêt cardiaque, traumatisme grave

Niveau 2 (ORANGE - Urgent):
Douleur thoracique, accident vasculaire cérébral, fracture ouverte

Niveau 3 (JAUNE - Non urgent):
Blessure modérée, infection bénigne

Niveau 4 (VERT - Conseil infirmier):
Consultation légère, orientation

🛡️ ÉQUIPEMENTS DISPONIBLES
• 10 salles de trauma
• 6 salles de réanimation
• Laboratoire 24h/24
• Imagerie médicale (Scanner, Radiologie)
• Bloc opératoire d'urgence
• Hélisurface pour évacuations aéromédicales

💳 MODALITÉS DE PAIEMENT
• Sécurité sociale acceptée
• Cartes bancaires (CB, Mastercard, Visa)
• Arrangements de paiement possible
• Couverture d'urgence en cas de sinistre

📞 COORDONNÉES URGENCES
Hotline Urgences: +212 5 XX XX XX XX
Permanence: Entrée urgences (24h/24)
Appel SAMU: 15 (gratuit, prioritaire)

⚠️ FAUX APPELS AUX URGENCES
Ne pas appeler les urgences pour:
- Consultation simple (rendez-vous)
- Questions générales (appelez l'accueil)
- Avis infirmier non urgent (consultez un médecin)

👨‍⚕️ L'ÉQUIPE VOUS ÉCOUTE
Nos professionnels sont formés à:
• L'accueil de crise
• L'écoute et l'empathie
• La stabilisation rapide
• La coordination avec les spécialistes"
        ],
        [
            'titre' => 'Chirurgie',
            'contenu' => "SERVICES DE CHIRURGIE

Nos services de chirurgie générale et spécialisée vous accueillent.

🏥 NOTRE PLATEAU CHIRURGICAL
6 blocs opératoires équipés de:
• Systèmes de monitoring dernière génération
• Équipement de chirurgie assistée par robot
• Stérilisation ultramoderne
• Salles de réveil et récupération

👨‍⚕️ EQUIPES CHIRURGICALES
Chirurgiens experts en:
• Chirurgie générale
• Chirurgie digestive
• Chirurgie vasculaire
• Chirurgie thoracique
• Chirurgie orthopédique et traumatologie
• Chirurgie plastique et reconstructrice
• Urologie
• Ophtalmologie

✅ INTERVENTIONS COURANTES
• Appendicectomie
• Cholécystectomie
• Hernie
• Varices
• Fractures et luxations
• Cataracte
• Implants dentaires
• Chirurgie cosmétique

📋 AVANT VOTRE INTERVENTION
Consultation préopératoire:
• Évaluation médicale complète
• Examens biologiques
• Imagerie si besoin
• Explications de l'intervention
• Signature du consentement

Préparation à la maison:
• Jeûne: 6h avant l'intervention
• Vêtements amples et confortables
• Hygiène personnelle
• Apportez vos ordonnances

⏰ DÉROULEMENT DU JOUR J
1. Accueil et installation (08h00)
2. Visite anesthésiste (08h30)
3. Préparation en salle (09h00)
4. Intervention
5. Salle de réveil
6. Retour à la chambre

🏥 HOSPITALISATION POSTOPÉRATOIRE
Durée moyenne:
• Chirurgie ambulatoire: retour jour même
• Chirurgie simple: 1-2 jours
• Chirurgie majeure: 3-7 jours

Suivi postopératoire:
• Soins infirmiers quotidiens
• Kinésithérapie si besoin
• Consultation 15 jours après
• Suivi à 1 et 3 mois

💊 GESTION DE LA DOULEUR
Options de soulagement:
• Analgésiques per os
• Analgésiques IV
• Bloquer périduraux
• Gestion multimodale de la douleur"
        ],
        [
            'titre' => 'Maternité',
            'contenu' => "MATERNITÉ - SUIVI GROSSESSE ET ACCOUCHEMENT

Bienvenue dans notre maternité moderne. Un suivi complet de la grossesse jusqu'à après l'accouchement.

🤰 SUIVI DE LA GROSSESSE
Notre équipe d'obstétriciens vous propose:
• Suivi mensuel du 1er trimestre
• Contrôles échographiques (3 échographies)
• Tests de dépistage prénatal
• Préparation à l'accouchement
• Consultations nutritionnistes
• Soutien psychologique

📅 CONSULTATIONS PRÉNATALES
Trimestre 1 (0-12 semaines):
• Confirmation de la grossesse
• Détermination du groupe sanguin
• Dépistage des infections

Trimestre 2 (13-28 semaines):
• Échographie de morphologie
• Tests de dépistage
• Surveillance tensionnelle

Trimestre 3 (28-40 semaines):
• Consultations tous les 15 jours puis hebdomadaires
• Monitoring fœtal
• Préparation à l'accouchement

🏥 FACILITÉS DE NOTRE MATERNITÉ
• 25 chambres individuelles avec vue
• Chambres \"peau-à-peau\" après accouchement
• Salle de naissance équipée
• Néonatalogie pédiatrique
• Allaitement soutenu par lactation spécialisée

👶 ACCOUCHEMENT
Nous proposons:
• Accouchement par voie basse
• Césarienne programmée ou urgence
• Anesthésie péridurale
• Présence du partenaire autorisée
• Intimité et respect du rythme naturel

🎯 NOTRE APPROCHE
• Accouchement physiologique favorisé
• Mobilité pendant le travail
• Alternative thérapeutique (ballon, bassin d'eau)
• Respect du projet de naissance

👨‍👩‍👧‍👦 APRÈS L'ACCOUCHEMENT
Suivi postnatal:
• Chambre mère-enfant 3-4 jours
• Guidance allaitement 24h/24
• Examen du nouveau-né
• Conseils hygiène et sécurité
• Test de dépistage néonatal

📞 NUMÉRO D'URGENCE MATERNITÉ
Hotline maternité: +212 5 XX XX XX XX
Admission urgence: 24h/24

🚗 ARRIVÉE À LA MATERNITÉ
En cas de rupture de sac amniotique, contractions régulières ou saignement:
Appelez immédiatement la maternité pour instructions"
        ],
        [
            'titre' => 'Consultations externes',
            'contenu' => "CONSULTATIONS SPÉCIALISÉES ET GÉNÉRALISTES

Accédez à nos consultations spécialisées et généralistes.

🏥 SPÉCIALISTES DISPONIBLES
Nos médecins expérimentés offrent:
• Médecine générale
• Cardiologie
• Pneumologie
• Gastro-entérologie
• Rhumatologie
• Endocrinologie
• Neurologie
• Psychiatrie et psychologie
• Orthopédie
• Urologie
• ORL (Oto-Rhino-Laryngologie)
• Ophtalmologie
• Dermatologie
• Infectious Disease
• Hématologie-Oncologie

📋 PREMIÈRE CONSULTATION
Avant votre visite:
• Préparez l'historique médical
• Rassemblez les antécédents
• Notez vos symptômes actuels
• Apportez vos anciens rapports

À l'accueil:
• Enregistrement des données
• Mise à jour des coordonnées
• Vérification de l'assurance
• Questionnaire médical

⏰ DÉROULEMENT DE LA CONSULTATION
1. Accueil par l'infirmière (tension, poids, température)
2. Consultation avec le médecin (30-45 min)
3. Examens complémentaires si besoin
4. Ordonnances et conseils
5. Prise de rendez-vous de suivi

🔬 EXAMENS COMPLÉMENTAIRES
Disponibles sur site:
• Laboratoire d'analyses
• Radiologie et imagerie
• ECG (Électrocardiogramme)
• Spirométrie (tests respiratoires)
• Endoscopie
• Échographie
• IRM et Scanner

📞 PRENDRE RENDEZ-VOUS
En ligne: www.hopital-medicare.ma/rdv
Par téléphone: +212 5 XX XX XX XX
À l'accueil: Lun-Ven 08h00-17h00

💳 TARIFICATION
Les tarifs sont:
• Affichés à l'accueil
• Sur le site internet
• Facturés après consultation
• Éligibles à la couverture sociale

🏃 CONSULTATION D'URGENCE
Pour une consultation urgente hors heures:
Appelez le standard (urgences) 24h/24"
        ],
        [
            'titre' => 'Présentation',
            'contenu' => "DÉCOUVREZ L'HÔPITAL MEDICARE

L'histoire et les valeurs de l'hôpital Medicare.

📜 NOTRE HISTOIRE
Fondée en 1995, l'Hôpital Medicare est devenu l'un des établissements de santé les plus importants de la région.

De ses débuts modestes avec 50 lits et une dizaine de médecins, Medicare a grandi pour devenir:
• 500+ lits de hospitalisation
• 150+ médecins spécialisés
• 600+ agents administratifs et techniques
• Plus de 200,000 patients traités par an

🎯 NOTRE MISSION
Fournir des soins de qualité, accessibles et respectueux à toute la population, en mettant l'accent sur l'excellence clinique et le bien-être du patient.

💚 NOS VALEURS
• Excellence: Recherche de l'excellence en tous domaines
• Humanité: Respect, dignité et compassion envers tous
• Intégrité: Professionnalisme et éthique irréprochable
• Innovation: Adoption des technologies et pratiques innovantes
• Collaboration: Travail d'équipe et multidisciplinarité

🏭 NOS INSTALLATIONS
• 6 blocs opératoires ultramodernes
• 10 salles de trauma
• Service de réanimation complet
• Laboratoire analytique 24h/24
• Imagerie médicale de pointe
• 1000+ places de parking

🌍 ACCRÉDITATIONS INTERNATIONALES
• ISO 9001:2015 (Qualité)
• Joint Commission International (JCI)
• Conformité RGPD
• Certifications de sécurité sanitaire

👨‍⚕️ NOTRE ÉQUIPE
• 150+ médecins spécialisés
• 300+ infirmiers
• 150+ aides-soignants
• 200+ agents administratifs et techniques
• Formations continues obligatoires

📚 RECHERCHE ET ENSEIGNEMENT
Nous collaborons avec:
• Universités médicales nationales
• Instituts de recherche internationaux
• Écoles paramédicales
• Programmes de doctorat

🌟 RÉCOMPENSES ET DISTINCTIONS
• Prix du meilleur hôpital (2022, 2023)
• Accréditation Excellence Médicale (2023)
• Recognition for Patient Safety (2023)
• Leaders in Innovation Healthcare (2022)"
        ],
        [
            'titre' => 'Recherche clinique',
            'contenu' => "PARTICIPEZ À NOS PROGRAMMES DE RECHERCHE

Contribuez à l'avancée médicale en participant à nos études cliniques.

🔬 QU'EST-CE QUE LA RECHERCHE CLINIQUE?
La recherche clinique permet de:
• Évaluer de nouveaux traitements
• Améliorer les pratiques existantes
• Contribuer aux connaissances scientifiques
• Bénéficier potentiellement aux patients futurs

📋 ÉTUDES EN COURS
Notre hôpital conduit actuellement des études sur:
• Cardiopathies ischémiques
• Diabète et maladies métaboliques
• Cancers (oncologie)
• Maladies neurodégénératives
• Pathologies infectieuses
• Asthme et allergies

✅ CRITÈRES DE PARTICIPATION
Pour participer, vous devez:
• Avoir au moins 18 ans
• Correspondre aux critères d'inclusion
• Donner votre consentement libre et éclairé
• Être en bonne compréhension du français

❌ RAISONS D'EXCLUSION
Certaines conditions peuvent vous exclure:
• Autres traitements interférant
• Grossesse
• Antécédents contre-indiquant
• Maladies non contrôlées

🛡️ PROTECTION DU PARTICIPANT
Tous les études respectent:
• Déclaration d'Helsinki
• Bonnes pratiques cliniques (GCP)
• Approbation éthique
• Consentement informé
• Droit de se retirer à tout moment
• Compensation des préjudices

💰 COMPENSATION
Certaines études proposent:
• Remboursement des déplacements
• Compensation pour le temps
• Gratuité du suivi médical
• Parfois honoraires directs

📝 PROCESSUS DE PARTICIPATION
1. Information sur l'étude
2. Visite de screening (sélection)
3. Signature du consentement
4. Phase d'inclusion (tests initiaux)
5. Suivi pendant l'étude
6. Suivi post-étude

📞 CONTACT - RECHERCHE CLINIQUE
Email: recherche@hopital-medicare.ma
Téléphone: +212 5 XX XX XX XX
Bureau: 2e étage, Aile Recherche"
        ],
        [
            'titre' => 'Enseignement',
            'contenu' => "ENSEIGNEMENT MÉDICAL

L'hôpital accueille des étudiants en médecine et formations paramédicales.

🎓 FORMATIONS PROPOSÉES
• Médecine générale
• Spécialités médicales
• Diplômes de nursing
• Techniques de radiologie
• Technologie de laboratoire
• Paramédical spécialisé
• Formation continue professionnelle

👨‍🎓 NOMBRE D'ÉTUDIANTS
Chaque année:
• 50+ étudiants en médecine
• 100+ étudiants paramédicaux
• 30+ résidents
• 200+ internes en rotation

🏫 NOTRE MISSION PÉDAGOGIQUE
Nous formons les futurs professionnels de santé par:
• Apprentissage pratique supervisé
• Mentorat personnalisé
• Cas cliniques réels
• Simulation médicale

🏥 ENVIRONNEMENT D'APPRENTISSAGE
Nos étudiants bénéficient de:
• Salles de cours équipées
• Laboratoires de simulation
• Accès aux dossiers patients (confidentialité respectée)
• Bibliothèque médicale complète
• Centre de ressources informatiques

📚 PARTENARIATS ACADÉMIQUES
Collaboration avec:
• Université de Médecine locale
• Instituts de recherche internationaux
• Écoles supérieures paramédicales
• Organisations médicales mondiales

🔬 RECHERCHE DANS L'ENSEIGNEMENT
• Participation à études cliniques
• Publications scientifiques
• Présentations à conférences
• Projets innovants d'étudiants

💡 PROGRAMME D'EXCELLENCE
• Sélection des meilleurs étudiants
• Bourse et aides financières
• Opportunités de mobilité internationale
• Accès prioritaire aux postes

🤝 SOUTIEN AUX ÉTUDIANTS
• Conseil académique
• Soutien psychologique
• Activités sportives et sociales
• Logement résidence universitaire"
        ],
        [
            'titre' => 'Recrutement',
            'contenu' => "REJOIGNEZ NOTRE ÉQUIPE!

Consulter nos offres d'emploi et développez votre carrière chez Medicare.

💼 POSTES RECHERCHÉS
Professionnels de santé:
• Médecins (généralistes et spécialistes)
• Infirmiers (urgences, réa, médecine générale)
• Aides-soignants
• Techniciens de laboratoire
• Techniciens de radiologie
• Pharmaciens
• Physiothérapeutes
• Nutritionnistes

Services:
• Responsable Qualité/Sécurité
• Coordinateur administratif
• Gestionnaire de dossiers patients
• Agents administratifs
• Agents de nettoyage
• Responsable logistique
• Cuisiniers et commis

🎯 PROFIL RECHERCHÉ
• Diplômes requis validés
• Expérience pertinente (variable selon le poste)
• Excellentes compétences relationnelles
• Engagement envers la qualité
• Capacité d'adaptation
• Intégrité professionnelle

📝 PROCESSUS DE CANDIDATURE
1. Consultez l'offre d'emploi détaillée
2. Préparez votre CV et lettre de motivation
3. Candidate en ligne ou papier
4. Entretien téléphonique de sélection
5. Tests/évaluations si nécessaire
6. Entretien final avec la direction
7. Offre d'embauche
8. Visite médicale
9. Intégration et formation

💰 RÉMUNÉRATION ET AVANTAGES
• Salaire compétitif
• Assurance maladie complète
• Régime de retraite
• Congés payés
• Formation continue gratuite
• Prime de performance
• Mutuelle familiale
• Tickets restaurants
• Aide au logement possible

👨‍💼 CULTURE DENTREPRISE
Chez Medicare:
• Environnement bienveillant
• Égalité des chances
• Liberté d'expression respectée
• Équilibre vie pro/personnelle
• Progression de carrière

📧 POSTULER
Email: rh@hopital-medicare.ma
Site: www.hopital-medicare.ma/offres
Téléphone: +212 5 XX XX XX XX
Horaires: Lun-Ven 08h00-17h00"
        ],
        [
            'titre' => 'Presse',
            'contenu' => "ACTUALITÉS DE L'HÔPITAL MEDICARE

Retrouvez les dernières actualités de l'hôpital Medicare.

📰 DERNIERS COMMUNIQUÉS
[JUIN 2026] Medicare accueille nouveau scanner dernier modèle
L'hôpital Medicare a acquis un scanner de 5e génération offrant une résolution supérieure et une réduction du temps d'examen de 40%.

[MAI 2026] Inauguration du Centre d'Oncologie
Investissement de 15 millions pour renforcer nos capacités de traitement du cancer avec équipement de protonthérapie.

[AVRIL 2026] 100000e patient traité
Un jalon important atteint avec le traitement du 100000e patient depuis l'ouverture.

[MARS 2026] Nouvelle aile pédiatrique
Ouverture d'une aile dédiée à la pédiatrie avec équipements adaptés aux enfants.

🏆 PRIX ET DISTINCTIONS
2023: Accréditation JCI (Excellence Internationale)
2023: Hôpital de l'Année (Prix Santé Maroc)
2022: Recognition for Patient Safety
2022: Leaders in Healthcare Innovation

🎤 INTERVIEWS
'Dr Ahmed Mohamed - Directeur Médical:
'Medicare continue d'innover pour offrir les meilleurs soins'

'Dr Fatima Benani - Chef Maternité:
'2000 bébés naissent avec succès chaque année'

📅 ÉVÉNEMENTS À VENIR
Juin 2026: Journée Portes Ouvertes
Juillet 2026: Conférence sur l'Oncologie moderne
Août 2026: Journée Mondiale du Cœur
Septembre 2026: Formations pour étudiants

📸 GALERIE PHOTOS
• Infrastructure ultramoderne
• Équipes en action
• Patient testimonials
• Événements et formations
• Innovations technologiques

📧 CONTACT PRESSE
Email: presse@hopital-medicare.ma
Téléphone: +212 5 XX XX XX XX
Relations Publiques: Lun-Ven 09h00-17h00

🤝 PARTENAIRES MÉDIAS
Medicare collabore avec les principaux médias nationaux et internationaux pour partager ses actualités."
        ],
    ];
    
    // Mettre à jour chaque page dans la base de données
    foreach ($pagesData as $page) {
        $stmt = $conn->prepare('UPDATE pages SET contenu = ? WHERE titre = ?');
        // Associer les paramètres contenus et titre à la requête préparée
        $stmt->bind_param('ss', $page['contenu'], $page['titre']);
        $stmt->execute();
        $stmt->close();
    }
    
    // Afficher une confirmation et proposer des liens de navigation
    echo "✅ Toutes les pages ont été mises à jour avec du contenu riche et détaillé!<br>";
    echo "<a href='manage_content.php'>Voir les pages →</a><br>";
    echo "<a href='patient.php'>Voir en tant que patient →</a>";
    
    // Fermer la connexion à la base de données
    $conn->close();
} catch (Exception $e) {
    // Afficher l'erreur en cas d'exception
    echo "❌ Erreur: " . $e->getMessage();
}
?>
