<?php
require_once 'security.php';

ini_set('display_errors', 0);
error_reporting(0);

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hopital";

$error = null;
$success = null;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("connexion échouée : " . $conn->connect_error);
    die("une erreur est survenue.");
}
?>


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
    if (empty($email) || empty($_POST['mot_de_passe_reg']) || empty($nom) || empty($prenom)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        //  ATTENTION : utilisateurs (avec S)
        $stmt = $conn->prepare("INSERT INTO utilisateurs (email, password_hash, role, nom, prenom) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $mot_de_passe, $role, $nom, $prenom);

        if ($stmt->execute()) {
            // Connexion automatique et redirection
            $stmt_login = $conn->prepare("SELECT id, role, nom, prenom FROM utilisateurs WHERE email = ?");
            $stmt_login->bind_param("s", $email);
            $stmt_login->execute();
            $result_login = $stmt_login->get_result();
            $user = $result_login->fetch_assoc();
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            
            $stmt_login->close();
            
            header("Location: patient.php");
            exit();
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
        
        <?php if (isset($error)) echo "<p class='error'>" . e($error) . "</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>" . e($success) . "</p>"; ?>

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

        <form id="login" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit" name="login">Se connecter</button>
        </form>

        <p style="margin-top: 20px; text-align: center;">
            Pas encore de compte ? 
            <button type="button" class="link-button" onclick="openRegisterModal()">Créer un compte</button>
        </p>
    </div>

    <!-- Modal d'inscription -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRegisterModal()">&times;</span>
            <h2>Créer un nouveau compte</h2>
            
            <form id="register" method="post">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
                
                <label for="email_reg">Email</label>
                <input type="email" id="email_reg" name="email_reg" placeholder="Votre email" required>
                
                <label for="password_reg">Mot de passe</label>
                <input type="password" id="password_reg" name="mot_de_passe_reg" placeholder="Entrez un mot de passe sécurisé" required>
                
                <input type="hidden" name="role" value="patient">
                <button type="submit" name="register">Créer mon compte</button>
            </form>
        </div>
    </div>

    <script>
        function openRegisterModal() {
            document.getElementById('registerModal').style.display = 'block';
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('registerModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
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