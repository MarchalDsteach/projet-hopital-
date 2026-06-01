<?php
require_once 'config.php';
secure_session_start();

$error = null;
$success = null;

try {
    $conn = get_db_connection();
} catch (RuntimeException $e) {
    $error = 'Erreur interne. Veuillez réessayer plus tard.';
    $conn = null;
}

$csrf_token = generate_csrf_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($submittedToken)) {
        $error = 'Requête invalide. Rechargez la page et réessayez.';
    } elseif (isset($_POST['login'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';

        if (!$email || empty($mot_de_passe)) {
            $error = 'Email ou mot de passe invalide.';
        } elseif ($conn) {
            $stmt = $conn->prepare('SELECT id, role, nom, prenom, password_hash FROM utilisateurs WHERE email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (!password_verify($mot_de_passe, $user['password_hash'])) {
                    $error = 'Email ou mot de passe incorrect.';
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['nom'] = $user['nom'];
                    $_SESSION['prenom'] = $user['prenom'];
                    session_regenerate_id(true);

                    $redirectPage = $user['role'] . '.php';
                    if (!file_exists($redirectPage)) {
                        $redirectPage = 'home.php';
                    }
                    safe_redirect($redirectPage);
                }
            } else {
                $error = 'Email ou mot de passe incorrect.';
            }

            $stmt->close();
        }
    } elseif (isset($_POST['register'])) {
        $email = filter_input(INPUT_POST, 'email_reg', FILTER_VALIDATE_EMAIL);
        $mot_de_passe_raw = $_POST['mot_de_passe_reg'] ?? '';
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $role = 'patient';

        if (!$email || empty($mot_de_passe_raw) || empty($nom) || empty($prenom)) {
            $error = 'Veuillez remplir tous les champs.';
        } elseif (strlen($mot_de_passe_raw) < 8) {
            $error = 'Le mot de passe doit contenir au moins 8 caractères.';
        } elseif (!preg_match('/^[\p{L} \-\']+$/u', $nom) || !preg_match('/^[\p{L} \-\']+$/u', $prenom)) {
            $error = 'Nom ou prénom invalide.';
        } elseif ($conn) {
            $password_hash = password_hash($mot_de_passe_raw, PASSWORD_DEFAULT);
            $nom = html_escape($nom);
            $prenom = html_escape($prenom);

            $stmt = $conn->prepare('INSERT INTO utilisateurs (email, password_hash, role, nom, prenom) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('sssss', $email, $password_hash, $role, $nom, $prenom);

            if ($stmt->execute()) {
                $stmt_login = $conn->prepare('SELECT id, role, nom, prenom FROM utilisateurs WHERE email = ?');
                $stmt_login->bind_param('s', $email);
                $stmt_login->execute();
                $result_login = $stmt_login->get_result();
                $user = $result_login->fetch_assoc();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                session_regenerate_id(true);

                $stmt_login->close();
                safe_redirect('patient.php');
            } else {
                $error = 'Impossible de créer ce compte. Vérifiez vos informations.';
            }

            $stmt->close();
        }
    }
}

if ($conn instanceof mysqli) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Hôpital Medicare</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="global.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
    <div class="container">
        <h1>Hôpital Medicare - Connexion</h1>
        
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <div id="googleMessage" class="message" style="display:none;"></div>

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
            <input type="hidden" name="csrf_token" value="<?php echo html_escape($csrf_token); ?>">
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
                <input type="hidden" name="csrf_token" value="<?php echo html_escape($csrf_token); ?>">
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
                    displayGoogleMessage('Erreur de connexion Google: ' + data.message, true);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displayGoogleMessage('Erreur lors de la connexion Google. Veuillez réessayer.', true);
            });
        }

        function displayGoogleMessage(message, isError = true) {
            const messageBox = document.getElementById('googleMessage');
            if (!messageBox) {
                alert(message);
                return;
            }
            messageBox.textContent = message;
            messageBox.className = isError ? 'message error' : 'message success';
            messageBox.style.display = 'block';
        }
    </script>
    <script src="main.js" defer></script>
</body>
</html>