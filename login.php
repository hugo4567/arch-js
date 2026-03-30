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
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap');

body {
    margin: 0;
    padding: 40px 20px;
    font-family: 'Quicksand', sans-serif;
    
    /* Fond SMM2 beige/crème */
    background-color: #f3eee1; 
    background-image: radial-gradient(#e2d9c2 15%, transparent 15%);
    background-position: 0 0;
    background-size: 24px 24px;
    
    display: flex;
    justify-content: center;
    min-height: 100vh;
}

.main-container {
    width: 100%;
    max-width: 700px; /* Taille idéale pour empiler des cartes */
    display: flex;
    flex-direction: column;
    gap: 40px; /* C'EST ÇA QUI CRÉE L'ESPACE ENTRE TES 3 FORMULAIRES */
}

h1 {
    font-weight: 700;
    font-size: 2.2rem;
    text-align: left;
    color: #5d5348;
    margin-bottom: 20px;
    padding-left: 20px;
    position: relative;
    display: flex;
    align-items: center;
}

h1::before {
    content: '';
    position: absolute;
    left: 0;
    width: 8px;
    height: 100%;
    background-color: #f1c40f;
    border-radius: 4px;
}

.error-msg {
    background-color: #ffffff;
    color: #e74c3c;
    padding: 15px 20px;
    border-radius: 15px;
    text-align: center;
    font-weight: 700;
    border: 4px solid #e74c3c;
    box-shadow: 0 6px 0 rgba(231, 76, 60, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
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