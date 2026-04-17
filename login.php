<?php
session_start();
session_regenerate_id(true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hopital";

$error = null;
$success = null;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}


// Traitement du formulaire de connexion
if (isset($_POST['login'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $stmt = $conn->prepare("SELECT id, role, nom, prenom, password_hash FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $mot_de_passe = $_POST['mot_de_passe'] ?? '';

if (!password_verify($mot_de_passe, $user['password_hash'])) {
            $error = "Mot de passe incorrect.";
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];

            header("Location: " . $user['role'] . ".php");
            exit();
        }
    } else {
        $error = "Utilisateur introuvable.";
    }

    $stmt->close();
}
// Traitement du formulaire d'inscription
if (isset($_POST['register'])) {
    $email = filter_var($_POST['email_reg'], FILTER_SANITIZE_EMAIL);
    $mot_de_passe = password_hash($_POST['mot_de_passe_reg'], PASSWORD_DEFAULT);
    $role = "patient"; //  on force ici
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);

    //  Vérification des champs
    if (empty($email) || empty($_POST['mot_de_passe_reg'])) {
        $error = "Veuillez remplir tous les champs";
    } else {
        //  ATTENTION : utilisateurs (avec S)
        $stmt = $conn->prepare("INSERT INTO utilisateurs (email, password_hash, role, nom, prenom) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $mot_de_passe, $role, $nom, $prenom);

        if ($stmt->execute()) {
            $success = "Compte créé avec succès.";
        } else {
            $error = "Email déjà utilisé.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
    <div class="container">
        <h1>Hôpital Medicare - Connexion</h1>
        
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <div class="google-login">
            <div id="g_id_onload"
                 data-client_id="989221879491-ldu7ab5ikrsn0v737itkru6ek9m57bbk.apps.googleusercontent.com"
                 data-callback="handleGoogleSignIn">
            </div>
            <div class="g_id_signin" data-type="standard"></div>
        </div>

        <div class="or-divider">
            <span>ou</span>
        </div>

        <div class="tabs">
            <button class="tab-button active" onclick="showTab('login', event)">Connexion</button>
            <button class="tab-button" onclick="showTab('register', event)">Créer un compte</button>
        </div>

        <form id="login" class="tab active" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit" name="login">Se connecter</button>
        </form>

        <form id="register" class="tab" method="post">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email_reg" placeholder="Email" required>
            <input type="password" name="mot_de_passe_reg" placeholder="Mot de passe" required>
            <input type="hidden" name="role" value="patient">
            <button type="submit" name="register">Créer un compte</button>
        </form>
    </div>

    <script>
        function showTab(tabName, event) {
        const tabs = document.querySelectorAll('.tab');
        const buttons = document.querySelectorAll('.tab-button');

        tabs.forEach(tab => tab.classList.remove('active'));
        buttons.forEach(button => button.classList.remove('active'));

        document.getElementById(tabName).classList.add('active');
        event.currentTarget.classList.add('active');
    }

        function handleGoogleSignIn(response) {
            // Send the JWT token to the server for verification
            fetch('google_login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ token: response.credential })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect based on role
                    switch (data.role) {
                        case 'admin':
                            window.location.href = 'admin.php';
                            break;
                        case 'medecin':
                            window.location.href = 'medecin.php';
                            break;
                        case 'infirmiere':
                            window.location.href = 'infirmiere.php';
                            break;
                        case 'patient':
                            window.location.href = 'patient.php';
                            break;
                        case 'technicien':
                            window.location.href = 'technicien.php';
                            break;
                        case 'utilisateur':
                            window.location.href = 'utilisateur.php';
                            break;
                        case 'comptable':
                            window.location.href = 'comptable.php';
                            break;
                        case 'accueil':
                            window.location.href = 'accueil.php';
                            break;
                        default:
                            window.location.href = 'autre.php';
                            break;
                    }
                } else {
                    alert('Erreur de connexion Google: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la connexion Google');
            });
        }
    </script>
</body>
</html>