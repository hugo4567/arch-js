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
/* --- Importation des polices --- */
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Quicksand:wght@500;700&display=swap');

body {
    margin: 0;
    padding: 60px 20px;
    font-family: 'Quicksand', sans-serif;
    /* Fond briques Pixel - VERSION ASSOMBRIE (Thème Nuit) */
    background: #111e22 radial-gradient(#2c3e50 20%, transparent 20%) 0 0,
                #111e22 radial-gradient(#2c3e50 20%, transparent 20%) 8px 8px;
    background-size: 16px 16px;
    image-rendering: pixelated;
    display: flex;
    justify-content: center;
}

.main-container {
    width: 100%;
    max-width: 650px;
}

h1 {
    font-family: 'Press Start 2P', cursive;
    font-size: 1.3rem;
    text-align: center;
    color: #eee; /* Texte clair */
    text-shadow: 3px 3px 0 #c0392b, 5px 5px 0 rgba(0,0,0,0.6); /* Ombre 3D Rouge Sombre */
    margin-bottom: 50px;
    line-height: 1.8;
}

/* --- Message d'erreur (adapté au Dark Mode) --- */
.error-msg {
    background-color: #c0392b; /* Rouge plus sombre */
    color: white;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    font-weight: 700;
    margin-bottom: 25px;
    border: 4px solid #e74c3c; /* Bordure rouge vive */
    box-shadow: 0 6px 0 rgba(0,0,0,0.2);
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