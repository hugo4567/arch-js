<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérifie le chemin de ta BDD (Attention aux majuscules !)
$db_path = "Backend/DB/db_connect.php"; 

if (file_exists($db_path)) {
    include($db_path);
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST["login"] ?? "";
    $passwd = $_POST["passwd"] ?? "";
    $role = $_POST["role"] ?? "";

    if ($role === "admin") {
        $admin_auth_path = "Backend/Auth/admin.auth.php";
        include($admin_auth_path);
        if (admin_auth($conn, $login, $passwd)) {
            $_SESSION["admin"] = time();
            header("Location: AdminPannel.php"); // Redirige vers admin panel pour le moment
            exit;
        } else { $error = "Identifiants Admin incorrects !"; }
    } 
    elseif ($role === "createur") {
        $crea_auth_path = "Backend/Auth/crea.auth.php";
        include($crea_auth_path);
        if (crea_auth($conn, $login, $passwd)) {
            $_SESSION["crea"] = $login;
            header("Location: editor.php");
            exit;
        } else { $error = "Identifiants Créateur incorrects !"; }
    }
    elseif ($role === "joueur") {
        if ($login === "player" && $passwd === "player") {
            $_SESSION["joueur"] = $login;
            header("Location: espace_joueur.php");
            exit;
        } else { $error = "Identifiants Joueur incorrects !"; }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> - CONNEXION - </title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-login">

    <?php if ($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="scene">
        <div class="carousel" id="carousel">
            
            <div class="carousel__face face-admin">
                <div class="login-card">
                    <h1>ADMINISTRATION</h1>
                    <a href="./index.php" id='exit'>SORTIR D'ICI</a>
                    <form method="POST" action="">
                        <input type="hidden" name="role" value="admin">
                        <div class="form-group">
                            <label>Identification</label>
                            <input type="text" name="login" required placeholder="ID Admin">
                        </div>
                        <div class="form-group">
                            <label>Code de Sécurité</label>
                            <input type="password" name="passwd" required placeholder="••••••••">
                        </div>
                        <button type="submit">SE CONNECTER</button>
                    </form>
                </div>
            </div>

            <div class="carousel__face face-createur">
                <div class="login-card">
                    <h1>CRÉATEUR</h1>
                    <form method="POST" action="">
                        <input type="hidden" name="role" value="createur">
                        <div class="form-group">
                            <label>Identifiant</label>
                            <input type="text" name="login" required placeholder="ID Créateur">
                        </div>
                        <div class="form-group">
                            <label>Code de Sécurité</label>
                            <input type="password" name="passwd" required placeholder="••••••••">
                        </div>
                        <button type="submit">ACCÉDER À L'ESPACE CREATEUR</button>
                    </form>
                </div>
            </div>

            <div class="carousel__face face-joueur">
                <div class="login-card">
                    <h1>JOUEUR</h1>
                    <form method="POST" action="">
                        <input type="hidden" name="role" value="joueur">
                        <div class="form-group">
                            <label>Identifiant</label>
                            <input type="text" name="login" required placeholder="ID Joueur">
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" name="passwd" required placeholder="••••••••">
                        </div>
                        <button type="submit">REJOINDRE LA PARTIE</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="controls">
        <button class="btn-nav" onclick="rotateCarousel(-1)">&#9664; PRÉCÉDENT</button>
        <button class="btn-nav" onclick="rotateCarousel(1)">SUIVANT &#9654;</button>
    </div>

    <script>
        let currentAngle = 0;
        const carousel = document.getElementById('carousel');
        const faces = document.querySelectorAll('.carousel__face');

        // Cette fonction est CRITIQUE : elle enlève le flou sur la face qui est devant et le remet sur celles de derrière
        function updateActiveFace() {
            let selectedIndex = Math.round(currentAngle / -120);
            let normalizedIndex = ((selectedIndex % 3) + 3) % 3; // Garde l'index entre 0 et 2

            faces.forEach((face, index) => {
                if (index === normalizedIndex) {
                    face.classList.add('active');
                } else {
                    face.classList.remove('active');
                }
            });
        }

        function rotateCarousel(direction) {
            // direction: 1 pour suivant (tourne vers la gauche), -1 pour précédent (tourne vers la droite)
            currentAngle -= direction * 120;
            carousel.style.transform = `rotateY(${currentAngle}deg)`;
            updateActiveFace(); // On met à jour le focus après la rotation
        }

        // On lance la fonction une première fois au chargement pour que la première face soit nette
        updateActiveFace();
    </script>

</body>
</html>
