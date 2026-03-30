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
    <title>Connexion</title>
    <style>
/* Importation des polices Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Russo+One&family=Share+Tech+Mono&display=swap');

/* =========================================
   VARIABLES DU THÈME "CYBER-URSS"
========================================= */
:root {
    --soviet-red: #da291c;
    --soviet-dark-red: #8b0000;
    --soviet-gold: #ffcd00;
    --bg-dark: #0f0f11;
    --bg-panel: #1a1a1d;
    --text-main: #e0e0e0;
    --neon-red: 0 0 10px #da291c, 0 0 20px #da291c;
    --neon-gold: 0 0 10px #ffcd00;
    --font-heading: 'Russo One', sans-serif;
    --font-ui: 'Share Tech Mono', monospace;
}

/* =========================================
   RESET & BASE
========================================= */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: var(--bg-dark);
    color: var(--text-main);
    font-family: var(--font-ui);
    line-height: 1.6;
    overflow-x: hidden;
    position: relative;
}

/* Effet Scanline (Typique rétro-gaming) */
.scanlines {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
    background-size: 100% 4px, 3px 100%;
    pointer-events: none; /* Laisse les clics passer au travers */
    z-index: 100;
}

/* =========================================
   TYPOGRAPHIE
========================================= */
h1, h2, h3 {
    font-family: var(--font-heading);
    text-transform: uppercase;
    letter-spacing: 2px;
}

h1 {
    color: var(--soviet-gold);
    text-shadow: var(--neon-gold);
    font-size: 3rem;
    margin-bottom: 10px;
}

h2 {
    color: var(--soviet-red);
    border-bottom: 2px solid var(--soviet-red);
    padding-bottom: 5px;
    margin-bottom: 20px;
}

.highlight {
    color: var(--soviet-gold);
    font-weight: bold;
    text-shadow: 0 0 5px var(--soviet-gold);
}

/* =========================================
   LAYOUT & PANNEAUX (Brutalisme)
========================================= */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    position: relative;
    z-index: 10;
}

.header {
    text-align: center;
    margin-bottom: 50px;
    border: 4px solid var(--soviet-red);
    padding: 30px;
    background: linear-gradient(45deg, #111, var(--soviet-dark-red));
    box-shadow: var(--neon-red);
}

.grid-layout {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.panel {
    background-color: var(--bg-panel);
    border: 2px solid #333;
    border-top: 4px solid var(--soviet-red);
    padding: 25px;
    position: relative;
    transition: all 0.3s ease;
}

/* Coin coupé style Sci-Fi / Militaire */
.panel::before {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 0;
    height: 0;
    border-bottom: 20px solid var(--bg-dark);
    border-left: 20px solid transparent;
}

.panel:hover {
    border-color: var(--soviet-red);
    box-shadow: inset 0 0 15px rgba(218, 41, 28, 0.2);
}

/* =========================================
   BOUTONS GAMING SOVIÉTIQUES
========================================= */
.btn-soviet {
    display: inline-block;
    width: 100%;
    background-color: var(--soviet-red);
    color: var(--soviet-gold);
    font-family: var(--font-heading);
    font-size: 1.2rem;
    padding: 15px 20px;
    border: 2px solid var(--soviet-gold);
    cursor: pointer;
    text-transform: uppercase;
    margin-top: 20px;
    transition: 0.2s;
    position: relative;
    overflow: hidden;
}

.btn-soviet:hover {
    background-color: var(--soviet-gold);
    color: var(--soviet-dark-red);
    box-shadow: var(--neon-gold);
}

/* Effet glitch au survol du bouton */
.btn-soviet:active {
    transform: scale(0.98);
}

/* =========================================
   ÉLÉMENTS SPÉCIFIQUES (Leaderboard)
========================================= */
.leaderboard {
    list-style: none;
}

.leaderboard li {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    background: #222;
    margin-bottom: 10px;
    border-left: 4px solid var(--soviet-gold);
    font-size: 1.1rem;
}

.leaderboard li:nth-child(1) {
    background: rgba(218, 41, 28, 0.2);
    border-left-color: var(--soviet-red);
    color: var(--soviet-gold);
    font-weight: bold;
    text-shadow: var(--neon-gold);
}

/* =========================================
   SCROLLBAR PERSONNALISÉE
========================================= */
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-track {
    background: var(--bg-dark);
}
::-webkit-scrollbar-thumb {
    background: var(--soviet-red);
    border: 1px solid var(--soviet-gold);
}
::-webkit-scrollbar-thumb:hover {
    background: var(--soviet-gold);
}
</style>
</head>
<body>

    <div class="main-wrapper">
        <h1>PORTAIL DE CONNEXION</h1>

        <?php if ($error): ?>
            <div class="error-msg">⚠️ <?php echo $error; ?></div>
        <?php endif; ?>

        <?php 
            // Inclusion dynamique des formulaires
            if (file_exists("form.php")) {
                include("form.php");
            } else {
                echo "<div style='color:white; background:red; padding:10px;'>Erreur : Fichier form.php introuvable ici : " . getcwd() . "</div>";
            }
        ?>
    </div>

</body>
</html>