<?php
// Test d'affichage simple
// echo "Le PHP fonctionne !"; 
// die(); 

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Déplace l'inclusion APRES l'activation des erreurs
if (file_exists("Backend/DB/db_connect.php")) {
    include("Backend/DB/db_connect.php");
} else {
    die("Erreur : Le fichier Backend/DB/db_connect.php est introuvable.");
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? ''; // N'oublie pas l'input hidden dans form.php !

    if ($role === "admin") {
        // Verif login/pass...
        header("Location: admin_dashboard.php");
        exit;
    } 
    elseif ($role === "createur") {
        // Verif login/pass...
        header("Location: createur_home.php");
        exit;
    }
    elseif ($role === "joueur") {
        // Verif login/pass...
        header("Location: espace_joueur.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Times New Roman", Georgia, Serif;
            background-color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        
        h1 {
            font-family: "Playfair Display";
            letter-spacing: 3px;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        
        form {
            display: grid;
            gap: 15px;
        }
        
        label {
            font-weight: bold;
            color: #2c3e50;
            font-size: 0.95rem;
        }
        
        input {
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        input:focus {
            outline: none;
            border-color: #2c3e50;
            box-shadow: 0 0 5px rgba(44, 62, 80, 0.3);
        }
        
        button {
            background-color: #2c3e50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }
        
        button:hover {
            background-color: #34495e;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <h1>Bienvenue sur la plateforme</h1>
        <?php 
            // C'est ici que la magie opère !
            // Le code de form.php sera "copié-collé" ici dynamiquement
            include("form.php"); 
        ?>
    </div>
</body>
</html>
