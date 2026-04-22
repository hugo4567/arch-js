<?php

function create_crea($conn, $login, $mdp){
    $sql = "INSERT INTO crea (login, mdp) value ('$login', '$mdp')";
    $query = mysqli_query($conn, $sql);
    return $query;
}


function update_crea($conn, $id_crea, $login, $mdp){
    $sql = "UPDATE creators SET login = $login, mdp = $mdp WHERE id_ = $id_crea";
    $query = mysqli_query($conn, $sql);
    return $query;
}

function delete_crea($conn, $id_crea){
    $sql = "DELETE FROM creators WHERE id_crea = $id_crea";
    $query = mysqli_query($conn, $sql);
    return $query;
}

function select_crea($conn){
    $sql = "SELECT * FROM creators";
    $query = mysqli_query($conn, $sql);
    $rs = creer_rs($query);
    return $rs;
}

function select_crea_login($conn, $login){
    $sql = "SELECT login, mdp FROM creators WHERE login = '$login'";
    $query = mysqli_query($conn, $sql);
    if (!$query){
        echo "<pre>Erreur SQL : " . mysqli_error($conn) . "</pre>";
        echo "<pre>Requête tentée : " . $sql . "</pre>";
        return false;
    }
    $rs = creer_rs($query);
    return $rs;
}

function get_crea_id($conn, $login, $mdp){
    $sql = "SELECT id_crea FROM creators WHERE login = '$login' AND mdp = '$mdp'";
    $query = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($query)) {
        return $row['id_crea'];
    }
    
    return false; // Retourne false si l'utilisateur n'est pas trouvé
}

function creer_rs($query){
    $rs = [];

    while ($row = mysqli_fetch_assoc($query)){
        $rs[] = $row;
    }

    return $rs;
}

?>