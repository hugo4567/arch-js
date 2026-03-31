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
    <title>SÉCURITÉ D'ÉTAT - CONNEXION</title>
    <style>
/* =========================================
   FONDATIONS & ATMOSPHÈRE GAMING
========================================= */
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500;800&family=Rajdhani:wght@500;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    /* Grille typique de Level Editor / Moteur 3D */
    background-color: #0b0e14;
    background-image: 
        linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
    background-size: 40px 40px;
    background-position: center center;
    
    color: #e2e8f0;
    font-family: 'Rajdhani', sans-serif;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
    overflow: hidden;
    position: relative;
}

/* Léger vignettage pour concentrer l'attention au centre */
body::after {
    content: "";
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: radial-gradient(circle, transparent 50%, #0b0e14 100%);
    z-index: 1;
    pointer-events: none;
}

/* =========================================
   MÉCANIQUE DU CARROUSEL 3D (OPTIMISÉE)
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
    
    /* Effet de profondeur sur les faces inactives */
    transition: opacity 0.6s ease, filter 0.6s ease;
    opacity: 0.15;
    filter: blur(4px);
    pointer-events: none; /* Empêche de cliquer sur les faces inactives */
}

/* La face active devient nette et cliquable */
.carousel__face.active {
    opacity: 1;
    filter: blur(0);
    pointer-events: auto;
}

/* Écartement optimisé pour éviter les collisions visuelles */
.face-admin { transform: rotateY(0deg) translateZ(320px); }
.face-createur { transform: rotateY(120deg) translateZ(320px); }
.face-joueur { transform: rotateY(240deg) translateZ(320px); }

/* =========================================
   CARTES DE CONNEXION (UI JEU)
========================================= */
.login-card {
    background-color: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 40px 30px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    position: relative;
    overflow: hidden;
}

/* Ligne néon dynamique en haut de chaque carte */
.login-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 4px;
}
.face-admin .login-card::before { background: #ef4444; box-shadow: 0 0 15px #ef4444; }
.face-createur .login-card::before { background: #a855f7; box-shadow: 0 0 15px #a855f7; }
.face-joueur .login-card::before { background: #10b981; box-shadow: 0 0 15px #10b981; }

h1 {
    font-family: 'Orbitron', sans-serif;
    font-weight: 800;
    font-size: 1.6rem;
    text-align: center;
    margin-bottom: 35px;
    letter-spacing: 2px;
}

.face-admin h1 { color: #ef4444; }
.face-createur h1 { color: #a855f7; }
.face-joueur h1 { color: #10b981; }

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    color: #94a3b8;
    margin-bottom: 8px;
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 14px 16px;
    background-color: rgba(0, 0, 0, 0.3);
    border: 2px solid #334155;
    border-radius: 6px;
    color: #fff;
    font-family: 'Rajdhani', sans-serif;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    outline: none;
}

input:focus {
    border-color: #3b82f6;
    background-color: rgba(59, 130, 246, 0.05);
}

button[type="submit"] {
    width: 100%;
    padding: 16px;
    margin-top: 20px;
    background-color: transparent;
    border-radius: 6px;
    font-family: 'Orbitron', sans-serif;
    font-size: 1.1rem;
    font-weight: 800;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.2s ease;
}

/* Boutons thématiques */
.face-admin button { border: 2px solid #ef4444; color: #ef4444; }
.face-admin button:hover { background: #ef4444; color: #fff; box-shadow: 0 0 20px rgba(239, 68, 68, 0.4); }

.face-createur button { border: 2px solid #a855f7; color: #a855f7; }
.face-createur button:hover { background: #a855f7; color: #fff; box-shadow: 0 0 20px rgba(168, 85, 247, 0.4); }

.face-joueur button { border: 2px solid #10b981; color: #10b981; }
.face-joueur button:hover { background: #10b981; color: #fff; box-shadow: 0 0 20px rgba(16, 185, 129, 0.4); }

/* =========================================
   CONTRÔLES DU CARROUSEL
========================================= */
.controls {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 20px;
    z-index: 20;
}

.btn-nav {
    background: transparent;
    color: #64748b;
    border: 2px solid #334155;
    border-radius: 6px;
    font-family: 'Orbitron', sans-serif;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
}

.btn-nav:hover {
    color: #fff;
    border-color: #3b82f6;
    background-color: rgba(59, 130, 246, 0.1);
}

/* =========================================
   LES ALERTES SYSTÈME
========================================= */
.error-msg {
    background-color: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    padding: 12px 20px;
    border-radius: 6px;
    border-left: 4px solid #ef4444;
    text-align: center;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 20px;
    z-index: 100;
    position: absolute;
    top: 30px;
    left: 50%;
    transform: translateX(-50%);
    min-width: 300px;
    backdrop-filter: blur(5px);
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
            </div>

            <div class="carousel__face face-createur">
                <div class="login-card">
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
            </div>

            <div class="carousel__face face-joueur">
                <div class="login-card">
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