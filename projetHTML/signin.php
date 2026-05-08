<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


$db_path = "Backend/DB/db_connect.php"; 

if (file_exists($db_path)) {
    include($db_path);



    if (isset($_POST["login"]) && isset($_POST["mdp"])){
        $user_crud_path = "Backend/CRUD/user.crud.php";
        include($user_crud_path);

        create_user($conn, $_POST["login"], $_POST["mdp"], [], 0);


        // redirection vers la page de login
        header("Location: login.php");
        exit;
    }
}

else {
    // Si ce message s'affiche, c'est que le chemin est faux
    die("Le chemin vers db_connect.php est incorrect : " . $db_path);
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>- INSCRIPTION -</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-login">
    <?php include 'navbar.php'; ?>

    <video autoplay muted loop playsinline class="bg-video">
        <source src="img/background.mp4" type="video/mp4">
    </video>


    <div class="login-center">
        <div class="scene">
            <div class="login-card">
                <div class="face-joueur-inscr">
                    <h1>JOUEUR</h1>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">   
                            <label>Définir l'identifiant</label>
                            <input type="text" name="login" required placeholder="identifiant">
                        </div>
                        <div class="form-group">
                            <label>Définir code de sécurité</label>
                            <input type="password" name="mdp" required placeholder="••••••••">
                        </div>
                        <button type="submit">S'INSCRIRE</button>

                    </form>
                </div>
        </div>
    </div>
 </div>

</body>
</html>