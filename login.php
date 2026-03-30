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
    /* Fond : Béton industriel et fer rouillé */
    background-color: #1a1a1d; 
    background-image: 
        linear-gradient(45deg, #111 25%, transparent 25%), 
        linear-gradient(-45deg, #111 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, #111 75%),
        linear-gradient(-45deg, transparent 75%, #111 75%),
        radial-gradient(#8b0000 1px, transparent 1px); /* Pointes de sang/rouille */
    background-size: 20px 20px, 20px 20px, 20px 20px, 20px 20px, 10px 10px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px, 0 0;
    
    color: #e0e0e0;
    font-family: 'Share Tech Mono', monospace; /* Police d'interface militaire */
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
    overflow-x: hidden;
    position: relative;
}

/* Effet d'écran cathodique (Scanlines) - OBLIGATOIRE pour le gaming rétro */
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
   LE TERMINAL CENTRAL D'ÉTAT
========================================= */
.state-terminal-container {
    width: 100%;
    max-width: 650px;
    background-color: #26262b; /* Métal sombre */
    border: 6px solid #da291c; /* Rouge Soviétique */
    padding: 30px;
    position: relative;
    box-shadow: 
        0 0 0 4px #ffcd00, /* Bordure dorée secondaire */
        0 20px 0 rgba(0,0,0,0.5), /* Ombre portée massive */
        inset 0 0 20px rgba(218, 41, 28, 0.3); /* Lueure rouge interne */
}

/* Les coins coupés Brutalistes */
.state-terminal-container::before,
.state-terminal-container::after {
    content: '';
    position: absolute;
    width: 40px;
    height: 40px;
    background-color: #1a1a1d; /* Même couleur que le fond body */
    z-index: 2;
}
/* Coin supérieur droit coupé */
.state-terminal-container::before {
    top: -6px;
    right: -6px;
    border-bottom: 6px solid #ffcd00;
    border-left: 6px solid #da291c;
}
/* Coin inférieur gauche coupé */
.state-terminal-container::after {
    bottom: -6px;
    left: -6px;
    border-top: 6px solid #da291c;
    border-right: 6px solid #ffcd00;
}

/* =========================================
   LE TITRE DE PROPAGANDE
========================================= */
h1 {
    font-family: 'Russo One', sans-serif; /* Police massive blocky */
    font-weight: 700;
    font-size: 2.5rem;
    text-transform: uppercase;
    text-align: center;
    color: #ffcd00; /* Or Soviétique */
    margin-bottom: 30px;
    padding: 15px;
    background-color: #da291c; /* Rouge */
    position: relative;
    letter-spacing: 2px;
    text-shadow: 2px 2px 0 #8b0000, -1px -1px 0 #000;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
    clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%); /* Forme dynamique */
}

h1::after {
    content: ' ☭'; /* L'emblème du peuple */
    color: #ffcd00;
}

/* =========================================
   LES ALERTES SYSTÈME (ERREURS)
========================================= */
.error-msg {
    background-color: #8b0000; /* Rouge foncé sang */
    color: #ffcd00; /* Texte or */
    padding: 20px;
    border: 4px solid #ffcd00;
    text-align: center;
    font-family: 'Share Tech Mono', monospace;
    font-weight: bold;
    font-size: 1.2rem;
    text-transform: uppercase;
    margin-bottom: 25px;
    position: relative;
    /* Animation d'alerte */
    animation: pulseAlerte 2s infinite;
}

@keyframes pulseAlerte {
    0% { box-shadow: 0 0 0 rgba(218, 41, 28, 0.7); }
    50% { box-shadow: 0 0 20px rgba(255, 205, 0, 0.9); }
    100% { box-shadow: 0 0 0 rgba(218, 41, 28, 0.7); }
}

/* Symbole d'alerte devant le message d'erreur */
.error-msg::before {
    content: '[ ALERTE ROUGE ] ';
    color: #fff;
    text-shadow: 0 0 5px #fff;
}

/* Style pour l'erreur PHP d'inclusion de fichier */
.php-file-error {
    color: #da291c;
    background: #000;
    padding: 10px;
    border: 2px dashed #da291c;
    font-family: 'Share Tech Mono', monospace;
    margin-top: 10px;
    text-align: center;
}
    </style>
</head>
<body>

    <div class="state-terminal-container">
        
        <h1>PROTOCOLE DE CONNEXION</h1>

        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php 
            // Inclusion dynamique des formulaires (les inputs devront être stylisés dans form.php pour le total look)
            if (file_exists("form.php")) {
                include("form.php");
            } else {
                // Erreur critique de fichier stylisée
                echo "<div class='php-file-error'>[ERREUR CRITIQUE] LE SOUS-SYSTÈME 'form.php' EST INTROUVABLE. SABOTAGE DÉTECTÉ.</div>";
            }
        ?>
    </div>

</body>
</html>