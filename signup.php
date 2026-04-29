<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$db_path = "Backend/DB/db_connect.php"; 

if (file_exists($db_path)) {
    require_once __DIR__ . $db_path;
}




if (isset($_POST["login"]) && isset($_POST["mdp"])){
    $user_crud_path = "Backend/CRUD/user.crud.php";
    require_once __DIR__ . $user_crud_path;

    create_user($conn, $_SESSION["login"], $_SESSION["mdp"], [], 0);


    // redirection vers la page de login
    header("Location: login.php");
    exit;
}


?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>- INSCRIPTION -</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>