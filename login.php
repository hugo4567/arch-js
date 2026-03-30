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
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap');

body {
    margin: 0;
    padding: 60px 20px;
    font-family: 'Quicksand', sans-serif;
    
    /* ON GARDE TON FOND D'ORIGINE */
    background-color: #111e22; 
    background-image: radial-gradient(#2c3e50 20%, transparent 20%),
                      radial-gradient(#2c3e50 20%, transparent 20%);
    background-position: 0 0, 8px 8px;
    background-size: 16px 16px;
    image-rendering: pixelated;

    display: flex;
    flex-direction: column;
    align-items: center;
}

.main-container {
    width: 100%;
    max-width: 650px;
    /* On ajoute un gap ici pour séparer les .login-wrap qui sont dedans */
    display: flex;
    flex-direction: column;
    gap: 40px; 
}

h1 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    text-align: center;
    color: #eee;
    text-shadow: 3px 3px 0 #d4ad0c; /* Ombre dorée SMM2 */
    margin-bottom: 20px;
}

/* --- Message d'erreur --- */
.error-msg {
    background-color: #c0392b;
    color: white;
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    font-weight: 700;
    margin-bottom: 25px;
    border: 4px solid #e74c3c;
    box-shadow: 0 6px 0 rgba(0,0,0,0.3);
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