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
        if ($login === "admin" && $passwd === "admin") {
            $_SESSION["admin"] = time();
            header("Location: AdminPannel.php"); // Redirige vers admin panel pour le moment
            exit;
        } else { $error = "Identifiants Admin incorrects !"; }
    } 
    elseif ($role === "createur") {
        if ($login === "crea" && $passwd === "crea") {
            $_SESSION["createur"] = $login;
            header("Location: createur_home.php");
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
    <style>
/* =========================================
   FONDATIONS & ATMOSPHÈRE RÉTRO/INDUSTRIELLE
========================================= */
/* Importation d'une police Pixel Art type NES */
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #000000;
    /* Création d'une grille type dither/pixel art très sombre */
    background-image: 
        linear-gradient(45deg, #111 25%, transparent 25%, transparent 75%, #111 75%, #111),
        linear-gradient(45deg, #111 25%, transparent 25%, transparent 75%, #111 75%, #111);
    background-size: 8px 8px;
    background-position: 0 0, 4px 4px;
    
    color: #ffffff;
    font-family: 'Press Start 2P', monospace;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
    overflow: hidden;
    position: relative;
}

/* =========================================
   MÉCANIQUE DU CARROUSEL 3D
========================================= */
.scene {
    perspective: 1000px;
    width: 100%;
    max-width: 420px;
    height: 550px;
    position: relative;
    z-index: 10;
}

.carousel {
    width: 100%;
    height: 100%;
    position: absolute;
    transform-style: preserve-3d;
    transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
}

.carousel__face {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    
    /* Plus de flou ! Juste une opacité et un assombrissement pour le style rétro */
    transition: opacity 0.6s ease, filter 0.6s ease;
    opacity: 0.4;
    filter: brightness(0.3) grayscale(50%);
    pointer-events: none;
}

.carousel__face.active {
    opacity: 1;
    filter: brightness(1) grayscale(0%);
    pointer-events: auto;
}

.face-admin { transform: rotateY(0deg) translateZ(320px); }
.face-createur { transform: rotateY(120deg) translateZ(320px); }
.face-joueur { transform: rotateY(240deg) translateZ(320px); }

/* =========================================
   CARTES DE CONNEXION (UI 8-BIT)
========================================= */
.login-card {
    background-color: #000000;
    /* Style "Boîte de dialogue NES" : bordure blanche épaisse avec une fausse double bordure interne */
    border: 4px solid #ffffff;
    border-radius: 0; /* Angles droits obligatoires en pixel art brut */
    padding: 40px 30px;
    box-shadow: 
        inset 0 0 0 2px #000000, 
        inset 0 0 0 4px #aaaaaa, /* Double ligne interne */
        12px 12px 0px rgba(255, 255, 255, 0.1); /* Ombre portée bloc */
    position: relative;
    overflow: hidden;
}

/* Bandeau coloré en blocs (remplace le néon) */
.login-card::before {
    content: '';
    position: absolute;
    top: 10px; left: 10px; right: 10px;
    height: 8px;
    image-rendering: pixelated;
}

/* Couleurs franches type palette 8-bit */
.face-admin .login-card::before { background: #e52521; } /* Rouge Mario */
.face-createur .login-card::before { background: #044bd9; } /* Bleu Glace (basé sur ton image) */
.face-joueur .login-card::before { background: #ffffff; } /* Blanc / Gris clair */

h1 {
    font-size: 1rem;
    text-align: center;
    margin-bottom: 35px;
    line-height: 1.5;
    text-transform: uppercase;
}

.face-admin h1 { color: #e52521; text-shadow: 2px 2px 0px #550000; }
.face-createur h1 { color: #044bd9; text-shadow: 2px 2px 0px #001144; }
.face-joueur h1 { color: #ffffff; text-shadow: 2px 2px 0px #555555; }

.form-group {
    margin-bottom: 25px;
}

label {
    display: block;
    color: #aaaaaa;
    margin-bottom: 10px;
    font-size: 0.7rem;
    text-transform: uppercase;
}

/* Champs de texte bruts */
input[type="text"], input[type="password"] {
    width: 100%;
    padding: 14px;
    background-color: #000000;
    border: 4px solid #555555;
    border-radius: 0;
    color: #ffffff;
    font-family: 'Press Start 2P', monospace;
    font-size: 0.8rem;
    outline: none;
}

input:focus {
    border-color: #ffffff;
    background-color: #111111;
}

/* Boutons massifs */
button[type="submit"] {
    width: 100%;
    padding: 16px;
    margin-top: 20px;
    background-color: #000000;
    border-radius: 0;
    font-family: 'Press Start 2P', monospace;
    font-size: 0.8rem;
    cursor: pointer;
    text-transform: uppercase;
    transition: transform 0.1s;
}

/* Effet de clic physique (bouton qui s'enfonce) */
button[type="submit"]:active {
    transform: translate(4px, 4px);
    box-shadow: none !important;
}

.face-admin button { 
    border: 4px solid #e52521; 
    color: #e52521; 
    box-shadow: 6px 6px 0px #e52521;
}
.face-admin button:hover { background: #e52521; color: #000; }

.face-createur button { 
    border: 4px solid #044bd9; 
    color: #044bd9; 
    box-shadow: 6px 6px 0px #044bd9;
}
.face-createur button:hover { background: #044bd9; color: #fff; }

.face-joueur button { 
    border: 4px solid #ffffff; 
    color: #ffffff; 
    box-shadow: 6px 6px 0px #ffffff;
}
.face-joueur button:hover { background: #ffffff; color: #000; }

/* =========================================
   CONTRÔLES DU CARROUSEL
========================================= */
.controls {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
    z-index: 20;
}

.btn-nav {
    background: #000000;
    color: #ffffff;
    border: 4px solid #555555;
    border-radius: 0;
    font-family: 'Press Start 2P', monospace;
    font-size: 0.7rem;
    cursor: pointer;
    padding: 12px 20px;
    box-shadow: 4px 4px 0px #555555;
}

.btn-nav:hover {
    border-color: #ffffff;
    background-color: #222222;
}

.btn-nav:active {
    transform: translate(4px, 4px);
    box-shadow: none;
}

/* =========================================
   LES ALERTES SYSTÈME (Type "Game Over")
========================================= */
.error-msg {
    background-color: #000000;
    color: #e52521;
    padding: 15px;
    border: 4px solid #e52521;
    border-radius: 0;
    text-align: center;
    font-size: 0.8rem;
    margin-bottom: 20px;
    z-index: 100;
    position: absolute;
    top: 30px;
    left: 50%;
    transform: translateX(-50%);
    min-width: 300px;
    box-shadow: 8px 8px 0px #550000;
    animation: blink 1s infinite;
}

@keyframes blink {
    0%, 100% { border-color: #e52521; }
    50% { border-color: #550000; }
}
</style>
</head>
<body>

    <?php if ($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="scene">
        <div class="carousel" id="carousel">
            
            <div class="carousel__face face-admin">
                <div class="login-card">
                    <h1>ADMINISTRATION</h1>
                    <a href="./index.php">SORTIR DICIniveau</a>
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
    <a href="./index.php">SORTIR DICIniveau</a>

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