<?php
session_start(); 

// On indique au navigateur qu'on va renvoyer du JSON
header('Content-Type: application/json');

require_once __DIR__ . "/../DB/db_connect.php"; // on verra si on a le temps ou fah
require_once __DIR__ . "/../CRUD/user.crud.php";

if (isset($_POST['coins']) && isset($_SESSION['id_user'])) {
    $totalCoins = (int)$_POST['coins'];

    $res = add_pieces_user($conn, $_SESSION['id_user'], $totalCoins);

    if (!$res){
        // C'est json_encode() qu'il faut utiliser pour envoyer des données
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'insertion dans la base de données."]);
    } else {
        echo json_encode(["status" => "success", "message" => "OK."]);
    }
} else {
    // Si la condition n'est pas remplie, on renvoie quand même une erreur au lieu de rien du tout
    echo json_encode(["status" => "error", "message" => "Utilisateur non connecté ou pièces manquantes."]);
}
?>