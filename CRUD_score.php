<?php

function create_score($conn, $enregistrement, $user_id, $score, $level_id){
    $sql = "INSERT INTO scores (enregistrement, user_id, score, level_id) VALUES ('$enregistrement', $user_id, $score, $level_id)";
    $squery = mysqli_query($conn, $sql);
    return $squery;
}

function read_scores($conn, $user_id){
    $sql = "SELECT * FROM scores WHERE user_id = $user_id";
    $squery = mysqli_query($conn, $sql);
    return mysqli_fetch_all($squery, MYSQLI_ASSOC);
}

function delete_score($conn, $enregistrement){
    $sql = "DELETE FROM scores WHERE id = $enregistrement";
    $squery = mysqli_query($conn, $sql);
    return $squery;
}

// Récupérer tous les scores avec joueur et niveau
function get_all_scores_with_details($conn){
    $sql = "SELECT u.nom as joueur, l.nom as niveau, s.score 
            FROM scores s
            JOIN users u ON s.user_id = u.id
            JOIN levels l ON s.level_id = l.id
            ORDER BY u.nom, l.nom";
    $squery = mysqlnqd($conn, $sql);
    return mysqli_fetch_all($squery, MYSQLI_ASSOC);
}