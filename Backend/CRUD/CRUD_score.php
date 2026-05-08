<?php

function create_score($conn, $user_id, $score, $level_id){
    $sql = "INSERT INTO scores (user_id, score, level_id) VALUES ($user_id, $score, $level_id)";
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


// Récupérer tous les scores avec joueur et niveau et les liste par jouer et niveau en fonction du score max général
function get_all_scores_with_details($conn){
    $sql = "SELECT u.login AS joueur,
                    l.name AS niveau,
                    s.score
                FROM scores AS s
                JOIN users AS u ON s.user_id = u.id_user
                JOIN levels AS l ON s.level_id = l.id
                ORDER BY s.score DESC, u.login ASC ";
    $squery = mysqli_query($conn, $sql);
    if (!$squery) {
        error_log("SQL error in get_all_scores_with_details: " . mysqli_error($conn) . " -- Query: " . $sql);// on utilise error_log pour ne pas afficher l'erreur à l'utilisateur mais la logger dans les logs du serveur
        return false;
    }
    $result = [];
    while ($row = mysqli_fetch_assoc($squery)) $result[] = $row;
    return $result;

}

//fonction qui liste le total des scores sur les niveaux
function get_total_scores_by_level($conn){
    $sql = "SELECT l.name AS niveau, SUM(s.score) AS total_score
            FROM scores AS s
            JOIN levels AS l ON s.level_id = l.id
            GROUP BY l.name
            ORDER BY total_score DESC";
    $squery = mysqli_query($conn, $sql);
    if (!$squery) {
        error_log("SQL error in get_total_scores_by_level: " . mysqli_error($conn) . " -- Query: " . $sql);
        return false;
    }
    $result = [];
    while ($row = mysqli_fetch_assoc($squery)) $result[] = $row;
    return $result;
}

//fonction qui liste le total des scores des joueurs
function get_total_scores_by_player($conn){
    $sql = "SELECT u.login AS joueur, SUM(s.score) AS total_score
            FROM scores AS s
            JOIN users AS u ON s.user_id = u.id_user
            GROUP BY u.login
            ORDER BY total_score DESC";
    $squery = mysqli_query($conn, $sql);
    if (!$squery) {
        error_log("SQL error in get_total_scores_by_player: " . mysqli_error($conn) . " -- Query: " . $sql);
        return false;
    }
    $result = [];
    while ($row = mysqli_fetch_assoc($squery)) $result[] = $row;
    return $result;
}