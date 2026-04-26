<?php
if (isset($_POST['coins']) && isset($_SESSION['id_user'])){
    $totalCoins = $_POST['coins'];

    include("../CRUD/user.crud.php");

    $piecesUser = get_pieces_user($conn, $id_user);

    $res = add_pieces_user($conn, $_SESSION['id_user'], $totalCoins)
}
?>