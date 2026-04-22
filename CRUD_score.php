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
    $sql = "SELECT users.login as joueur, levels.name as niveau, score.score 
            FROM scores users  levels 
            JOIN users ON score.user_id = users.id
            JOIN levels l ON s.level_id = levels.id
            ORDER BY users.nom, levels.nom";
    $squery = mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
    $result = []; 
    while ($row = mysqli_fetch_assoc($squery)) $result[] = $row;
    return $result;

}