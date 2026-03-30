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
            header("Location: index.php"); // Redirige vers ton accueil
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
    <title>SÉCURITÉ D'ÉTAT - CONNEXION</title>
    <style>
/* Importation de la typographie de l'acier et du peuple */
@import url('https://fonts.googleapis.com/css2?family=Russo+One&family=Share+Tech+Mono&display=swap');

/* =========================================
   PROTOCOLE ZÉRO : FONDATIONS & ATMOSPHÈRE
========================================= */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #1a1a1d; 
    background-image: 
        linear-gradient(45deg, #111 25%, transparent 25%), 
        linear-gradient(-45deg, #111 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, #111 75%),
        linear-gradient(-45deg, transparent 75%, #111 75%),
        radial-gradient(#8b0000 1px, transparent 1px);
    background-size: 20px 20px, 20px 20px, 20px 20px, 20px 20px, 10px 10px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px, 0 0;
    
    color: #e0e0e0;
    font-family: 'Share Tech Mono', monospace;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
    overflow-x: hidden;
    position: relative;
}

body::before {
    content: "";
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.3) 50%);
    background-size: 100% 4px;
    z-index: 1000;
    pointer-events: none;
    opacity: 0.6;
}

/* =========================================
   MÉCANIQUE DU CARROUSEL 3D
========================================= */
.scene {
    perspective: 1200px;
    width: 100%;
    max-width: 500px;
    height: 600px;
    position: relative;
    z-index: 10;
}

.carousel {
    width: 100%;
    height: 100%;
    position: absolute;
    transform-style: preserve-3d;
    transition: transform 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.carousel__face {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden; /* Cache l'arrière des autres faces */
    display: flex;
    flex-direction: column;
}

/* Placement en triangle équilatéral avec recul (TranslateZ) */
.face-admin { transform: rotateY(0deg) translateZ(280px); }
.face-createur { transform: rotateY(120deg) translateZ(280px); }
.face-joueur { transform: rotateY(240deg) translateZ(280px); }

/* =========================================
   LE TERMINAL CENTRAL D'ÉTAT (Appliqué aux faces)
========================================= */
.state-terminal-container {
    background-color: #26262b;
    border: 6px solid #da291c;
    padding: 30px;
    box-shadow: 
        0 0 0 4px #ffcd00,
        0 20px 40px rgba(0,0,0,0.8),
        inset 0 0 20px rgba(218, 41, 28, 0.3);
}

.state-terminal-container::before,
.state-terminal-container::after {
    content: '';
    position: absolute;
    width: 40px;
    height: 40px;
    background-color: #1a1a1d;
    z-index: 2;
}

.state-terminal-container::before {
    top: -6px; right: -6px;
    border-bottom: 6px solid #ffcd00;
    border-left: 6px solid #da291c;
}

.state-terminal-container::after {
    bottom: -6px; left: -6px;
    border-top: 6px solid #da291c;
    border-right: 6px solid #ffcd00;
}

/* =========================================
   TITRES & FORMULAIRES
========================================= */
h1 {
    font-family: 'Russo One', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    text-transform: uppercase;
    text-align: center;
    color: #ffcd00;
    margin-bottom: 30px;
    padding: 15px 5px;
    background-color: #da291c;
    position: relative;
    letter-spacing: 2px;
    text-shadow: 2px 2px 0 #8b0000, -1px -1px 0 #000;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
    clip-path: polygon(5% 0%, 100% 0%, 95% 100%, 0% 100%);
}

h1::after { content: ' ☭'; color: #ffcd00; }

.form-group {
    margin-bottom: 25px;
    position: relative;
    z-index: 5;
}

label {
    display: block;
    color: #ffcd00;
    margin-bottom: 8px;
    font-size: 1.1rem;
    text-transform: uppercase;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 15px;
    background-color: #111;
    border: 2px solid #555;
    color: #fff;
    font-family: 'Share Tech Mono', monospace;
    font-size: 1.2rem;
    transition: all 0.3s;
    outline: none;
}

input[type="text"]:focus, input[type="password"]:focus {
    border-color: #da291c;
    box-shadow: 0 0 10px rgba(218, 41, 28, 0.5);
}

button[type="submit"] {
    width: 100%;
    padding: 15px;
    background-color: #da291c;
    color: #ffcd00;
    border: 2px solid #ffcd00;
    font-family: 'Russo One', sans-serif;
    font-size: 1.2rem;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.3s;
    margin-top: 10px;
    position: relative;
    z-index: 5;
}

button[type="submit"]:hover {
    background-color: #ffcd00;
    color: #da291c;
    box-shadow: 0 0 15px #ffcd00;
}

/* =========================================
   CONTRÔLES DU CARROUSEL
========================================= */
.controls {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 40px;
    z-index: 20;
}

.btn-nav {
    background: #26262b;
    color: #ffcd00;
    border: 2px solid #da291c;
    padding: 10px 25px;
    font-family: 'Russo One', sans-serif;
    font-size: 1.5rem;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 4px 4px 0 #8b0000;
}

.btn-nav:hover {
    transform: translate(-2px, -2px);
    box-shadow: 6px 6px 0 #ffcd00;
    background: #da291c;
}

.btn-nav:active {
    transform: translate(2px, 2px);
    box-shadow: 2px 2px 0 #8b0000;
}

/* =========================================
   LES ALERTES SYSTÈME
========================================= */
.error-msg {
    background-color: #8b0000;
    color: #ffcd00;
    padding: 15px;
    border: 4px solid #ffcd00;
    text-align: center;
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 25px;
    z-index: 100;
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    min-width: 300px;
    animation: pulseAlerte 2s infinite;
}

@keyframes pulseAlerte {
    0% { box-shadow: 0 0 0 rgba(218, 41, 28, 0.7); }
    50% { box-shadow: 0 0 20px rgba(255, 205, 0, 0.9); }
    100% { box-shadow: 0 0 0 rgba(218, 41, 28, 0.7); }
}
.error-msg::before { content: '[ ALERTE ] '; color: #fff; }

    </style>
</head>
<body>

    <?php if ($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="scene">
        <div class="carousel" id="carousel">
            
            <div class="carousel__face face-admin state-terminal-container">
                <h1>ADMINISTRATION</h1>
                <form method="POST" action="">
                    <input type="hidden" name="role" value="admin">
                    <div class="form-group">
                        <label>Identification Cible</label>
                        <input type="text" name="login" required placeholder="ID Admin">
                    </div>
                    <div class="form-group">
                        <label>Code de Sécurité</label>
                        <input type="password" name="passwd" required placeholder="••••••••">
                    </div>
                    <button type="submit">INITIALISER ACCÈS</button>
                </form>
            </div>

            <div class="carousel__face face-createur state-terminal-container">
                <h1>CRÉATEUR</h1>
                <form method="POST" action="">
                    <input type="hidden" name="role" value="createur">
                    <div class="form-group">
                        <label>Matricule Ouvrier</label>
                        <input type="text" name="login" required placeholder="ID Créateur">
                    </div>
                    <div class="form-group">
                        <label>Clé d'Ingénierie</label>
                        <input type="password" name="passwd" required placeholder="••••••••">
                    </div>
                    <button type="submit">ACCÉDER À L'ATELIER</button>
                </form>
            </div>

            <div class="carousel__face face-joueur state-terminal-container">
                <h1>CITOYEN / JOUEUR</h1>
                <form method="POST" action="">
                    <input type="hidden" name="role" value="joueur">
                    <div class="form-group">
                        <label>Plaque d'Identité</label>
                        <input type="text" name="login" required placeholder="ID Joueur">
                    </div>
                    <div class="form-group">
                        <label>Passeport Numérique</label>
                        <input type="password" name="passwd" required placeholder="••••••••">
                    </div>
                    <button type="submit">REJOINDRE LA PARTIE</button>
                </form>
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

        function rotateCarousel(direction) {
            // direction: 1 pour suivant (tourne vers la gauche), -1 pour précédent (tourne vers la droite)
            currentAngle -= direction * 120;
            carousel.style.transform = `rotateY(${currentAngle}deg)`;
        }
    </script>

</body>
</html>