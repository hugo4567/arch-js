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
    <title>SMM2 - Connexion</title>
    <style>
        body {
            margin: 0;
            padding: 50px 20px;
            font-family: 'Quicksand', sans-serif;
            /* Fond Briques Pixel */
            background: #4a6a72 radial-gradient(#6c8b93 20%, transparent 20%) 0 0,
                        #4a6a72 radial-gradient(#6c8b93 20%, transparent 20%) 8px 8px;
            background-size: 16px 16px;
            image-rendering: pixelated;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .main-wrapper {
            width: 100%;
            max-width: 500px;
        }

        h1 {
            font-family: 'Press Start 2P', cursive;
            font-size: 1.1rem;
            color: #fff;
            text-align: center;
            text-shadow: 4px 4px 0 #e74c3c, 6px 6px 0 rgba(0,0,0,0.4);
            margin-bottom: 50px;
            line-height: 1.8;
        }

        .error-msg {
            background-color: #e74c3c;
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            font-weight: 700;
            margin-bottom: 25px;
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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