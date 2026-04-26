<?php
// ==========================================
// CRUD : USERS (avec gestion du JSON pour les levels)
// ==========================================

// --- 1. CREATE ---
function create_user($conn, $login, $mdp, $levels = [], $pieces) {
    
    $login = mysqli_real_escape_string($conn, $login);
    $mdp = mysqli_real_escape_string($conn, $mdp); 
    
    // On s'assure que $levels contient que des entiers (les IDs des niveaux)
    $levels_clean = array_map('intval', $levels);
    
    // Encodage en JSON pour la colonne longtext
    $levels_json = mysqli_real_escape_string($conn, json_encode($levels_clean));

    $sql = "INSERT INTO users (login, mdp, levels) 
            VALUES ('$login', '$mdp', '$levels_json', $pieces)";
            
    return mysqli_query($conn, $sql);
}

// POur avoir tout les users
function get_all_users($conn) {
    $sql = "SELECT * FROM users ORDER BY id_user DESC";
    $result = mysqli_query($conn, $sql);
    
    $users = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Transformation du texte JSON en tableau PHP exploitable, assez basique mais efficace
            $row['levels'] = json_decode($row['levels'], true) ?: [];
            $users[] = $row;
        }
    }
    return $users;
}

// read
function get_user_by_id($conn, $id_user) {
    $id_user = (int)$id_user;
    $sql = "SELECT * FROM users WHERE id_user = $id_user";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $row['levels'] = json_decode($row['levels'], true) ?: [];
        return $row; 
    }
    return null;
}

function get_user_by_login($conn, $login) {
    $login = mysqli_real_escape_string($conn, $login);
    $sql = "SELECT * FROM users WHERE login = '$login'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $row['levels'] = json_decode($row['levels'], true) ?: [];
        return $row; 
    }
    return null;
}

// update user
function update_user($conn, $id_user, $login, $mdp, $levels, $pieces) {
    $id_user = (int)$id_user;
    $login = mysqli_real_escape_string($conn, $login);
    $mdp = mysqli_real_escape_string($conn, $mdp);
    
    // Nettoyage et encodage JSON car ca pose probleme
    $levels_clean = array_map('intval', $levels);
    $levels_json = mysqli_real_escape_string($conn, json_encode($levels_clean));

    $sql = "UPDATE users 
            SET login='$login', mdp='$mdp', levels='$levels_json', pieces=$pieces 
            WHERE id_user=$id_user";

    return mysqli_query($conn, $sql);
}

// --- 5. DELETE ---
function delete_user($conn, $id_user) {
    $id_user = (int)$id_user;
    $sql = "DELETE FROM users WHERE id_user=$id_user";
    
    return mysqli_query($conn, $sql);
}

// ==========================================
// FONCTIONS UTILES (Spécifiques au tableau JSON)
// ==========================================

// Ajoute un ID de niveau à l'inventaire de l'utilisateur (s'il ne l'a pas déjà)
function add_level_to_user($conn, $id_user, $id_level_to_add) {//les scores sont gérés comment ????? par la magie du M ?
    $user = get_user_by_id($conn, $id_user);
    
    if ($user) {
        $levels = $user['levels']; // C'est déjà un array PHP grâce au get_user_by_id
        $id_level_to_add = (int)$id_level_to_add;
        
        // On vérifie que le joueur ne possède pas déjà ce niveau
        if (!in_array($id_level_to_add, $levels)) {
            $levels[] = $id_level_to_add; // On ajoute l'ID
            // On sauvegarde l'utilisateur avec son nouveau tableau
            return update_user($conn, $id_user, $user['login'], $user['mdp'], $levels, 0);
        }
        return true; // Il l'a déjà, on considère que c'est un succès
    }
    return false; // User non trouvé
}

// Retire un ID de niveau de l'inventaire de l'utilisateur
function remove_level_from_user($conn, $id_user, $id_level_to_remove) {
    $user = get_user_by_id($conn, $id_user);
    
    if ($user) {
        $levels = $user['levels'];
        $id_level_to_remove = (int)$id_level_to_remove;
        
        // On cherche la position du niveau dans le tableau
        $index = array_search($id_level_to_remove, $levels);
        if ($index !== false) {
            unset($levels[$index]); // On le supprime
            $levels = array_values($levels); // On réindexe le tableau proprement (0, 1, 2...)
            
            return update_user($conn, $id_user, $user['login'], $user['mdp'], $levels, 0);//je pense quil faudriat faire un join sur scores ou recup les pices du jeu a la fin du niveau
        }
        return true; // Il ne l'avait pas de toute façon
    }
    return false;
}


function select_user_login($conn, $login){
    $sql = "SELECT login, mdp FROM users WHERE login = '$login'";
    $query = mysqli_query($conn, $sql);
    if (!$query){
        echo "<pre>Erreur SQL : " . mysqli_error($conn) . "</pre>";
        echo "<pre>Requête tentée : " . $sql . "</pre>";
        return false;
    }
    $rs = creer_rs($query);
    return $rs;
}



function get_pieces_user($conn, $id_user){
    $sql = "SELECT pieces FROM users WHERE id_user=$id_user";
    $query = mysqli_query($conn, $sql);
    if (!$query){
        echo "<pre>Erreur SQL : " . mysqli_error($conn) . "</pre>";
        echo "<pre>Requête tentée : " . $sql . "</pre>";
        return false;
    }
    $rs = creer_rs($query);
    return $rs;
    }


function add_pieces_user($conn, $id_user, $pieces_add){
    $pieces = get_pieces_user($conn, $id_user)[0]["pieces"];

    $pieces_update = $pieces + $pieces_add;

    $sql = "UPDATE users 
            SET pieces=$pieces_update
            WHERE id_user=$id_user";

    return mysqli_query($conn, $sql);
}


function sub_pieces_user($conn, $id_user, $pieces_sub){
    $pieces_add = -$pieces_sub;
    return add_pieces_user($conn, $id_user, $pieces_add);
}

function creer_rs($query){
    $rs = [];

    while ($row = mysqli_fetch_assoc($query)){
        $rs[] = $row;
    }

    return $rs;
}

?>