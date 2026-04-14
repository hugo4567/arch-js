<?php

function create_admin($conn, $login, $mdp){
    $sql = "INSERT INTO admin (login, mdp) value ('$login', '$mdp')";
    $query = mysqli_query($conn, $sql);
    return $query;
}


function update_admin($conn, $id_admin, $login, $mdp){
    $sql = "UPDATE admin SET login = $login, mdp = $mdp WHERE id_admin = $id_admin";
    $query = mysqli_query($conn, $sql);
    return $query;
}

function delete_admin($conn, $id_admin){
    $sql = "DELETE FROM admin WHERE id_admin = $id_admin";
    $query = mysqli_query($conn, $sql);
    return $query;
}

function select_admin($conn){
    $sql = "SELECT * FROM admin";
    $query = mysqli_query($conn, $sql);
    $rs = creer_rs($query);
    return $rs;
}

function select_admin_login($conn, $login){
    $sql = "SELECT login, mdp FROM admin WHERE login = $login";
    $query = mysqli_query($conn, $sql);
    if (!$query){
        echo "Erreur.";
        return false;
    }
    $rs = creer_rs($query);
    return $rs;
}

function creer_rs($query){
    $rs = [];

    while ($row = mysqli_fetch_assoc($query)){
        $rs[] = $row;
    }

    return $rs;
}

?>