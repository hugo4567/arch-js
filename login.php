<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion BDD
if (file_exists("Backend/DB/db_connect.php")) {
    include("Backend/DB/db_connect.php");
} else {
    // On ne bloque pas tout pour le test, mais on prévient
    $error_db = "Base de données non connectée.";
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST["login"] ?? "";
    $passwd = $_POST["passwd"] ?? "";
    $role = $_POST["role"] ?? "";

    // Logique de redirection selon le rôle
    if ($role === "admin") {
        if ($login === "admin" && $passwd === "admin") {
            $_SESSION["admin"] = time();
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = "Identifiants Admin incorrects.";
        }
    } 
    elseif ($role === "createur") {
        // Test temporaire pour créateur
        if ($login === "crea" && $passwd === "crea") {
            $_SESSION["createur"] = $login;
            header("Location: createur_home.php");
            exit;
        } else {
            $error = "Identifiants Créateur incorrects.";
        }
    }
    elseif ($role === "joueur") {
        // Test temporaire pour joueur
        if ($login === "player" && $passwd === "player") {
            $_SESSION["joueur"] = $login;
            header("Location: espace_joueur.php");
            exit;
        } else {
            $error = "Identifiants Joueur incorrects.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Portail de Connexion</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
/* --- Importation des polices --- */
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Quicksand:wght@500;700&display=swap');

body {
    margin: 0;
    padding: 40px 20px;
    font-family: 'Quicksand', sans-serif;
    /* Fond briques Pixel */
    background: #4a6a72 radial-gradient(#6c8b93 20%, transparent 20%) 0 0,
                #4a6a72 radial-gradient(#6c8b93 20%, transparent 20%) 8px 8px;
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
    font-size: 1.2rem;
    text-align: center;
    color: #fff;
    text-shadow: 3px 3px 0 #e74c3c, 5px 5px 0 rgba(0,0,0,0.4);
    margin-bottom: 40px;
    line-height: 1.6;
}

.error-msg {
    background-color: #e74c3c;
    color: white;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    font-weight: 700;
    margin-bottom: 20px;
    border: 4px solid #c0392b;
    box-shadow: 0 4px 0 rgba(0,0,0,0.2);
}
</style>
</head>
<body>

    <div class="main-container">
        <h1>Plateforme Multi-Accès</h1>

        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php 
            // Inclusion des formulaires de form.php
            if (file_exists("form.php")) {
                include("form.php"); 
            } else {
                echo "Erreur : form.php introuvable.";
            }
        ?>
    </div>

</body>
</html>