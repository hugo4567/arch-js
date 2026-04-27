<?php
if (isset($_POST['coins']) && isset($_SESSION['id_user'])){
    $totalCoins = $_POST['coins'];

    include("../CRUD/user.crud.php");

    $res = add_pieces_user($conn, $_SESSION['id_user'], $totalCoins);

    if (!$res){
        echo json_decode("Erreur lors de l'insertion dans la base de donnée.");
    }

    else {
        echo json_encode("OK.");
    }
}
?>