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
        body {
            background-color: #ecf0f1;
            padding: 50px 20px;
            font-family: sans-serif;
        }
        .main-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 40px; }
        .error-msg { 
            background: #f8d7da; color: #721c24; 
            padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center;
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