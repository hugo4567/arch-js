<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$db_path = "/Backend/DB/db_connect.php"; 

if (file_exists($db_path)) {
    require_once __DIR__ . $db_path;



    if (isset($_POST["login"]) && isset($_POST["mdp"])){
        $user_crud_path = "/Backend/CRUD/user.crud.php";
        require_once __DIR__ . $user_crud_path;

        create_user($conn, $_SESSION["login"], $_SESSION["mdp"], [], 0);


        // redirection vers la page de login
        header("Location: login.php");
        exit;
    }
}

else
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>- INSCRIPTION -</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="">
    <?php include 'navbar.php'; ?>

    <video autoplay muted loop playsinline class="bg-video">
        <source src="img/background.mp4" type="video/mp4">
    </video>


<!-- Reste à faire le form d'inscription (flemme de le faire mnt) -->
 <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label>Définir l'identifiant</label>
    <input type="text" name="login" required placeholder="identifiant">

    <label>Définir code de sécurité</label>
    <input type="password" name="mdp" required placeholder="••••••••">

    <button type="submit">INSCRIPTION</button>

 </form>
</body>
</html>