<?php
// ==========================================
// CRUD : USERS (avec gestion du JSON pour les levels)
// ==========================================

// creer un utlisateur
function create_user($conn, $login, $mdp, $levels = [], $pieces) {
    
    $login = mysqli_real_escape_string($conn, $login);
    $mdp = mysqli_real_escape_string($conn, $mdp); 
    
    // demande si $levels contient que des entiers (les IDs des niveaux)
    $levels_clean = array_map('intval', $levels);
    //La fonction array map permet de creer un nouveau avec levels ou chaque case est convertie en entier
    // Encodage en JSON pour la colonne longtext
    $levels_json = mysqli_real_escape_string($conn, json_encode($levels_clean));
    //un tableau est transformé en une chaîne JSON et est ensuite sécurisé par escape string qui evite les injection sql
    $sql = "INSERT INTO users (login, mdp, levels, pieces) 
            VALUES ('$login', '$mdp', '$levels_json', $pieces)";
            
    return mysqli_query($conn, $sql);
}

// POur avoir tout les users
function get_all_users($conn) {
    $sql = "SELECT * FROM users ORDER BY id_user DESC";
    $result = mysqli_query($conn, $sql);
    
    $users = [];
    //num row est le nombre de lignes de result
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
//pour avoir l'user en fonction de son login
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
    $pieces = (int)$pieces; // Sécurité supplémentaire pour l'argent
    
    // 1. On encode directement le tableau PHP en JSON
    $json_string = json_encode($levels);
    
    // 2. On échappe la chaîne JSON pour éviter les injections SQL
    $levels_json = mysqli_real_escape_string($conn, $json_string);

    $sql = "UPDATE users 
            SET login='$login', mdp='$mdp', levels='$levels_json', pieces=$pieces 
            WHERE id_user=$id_user";

    // 3. Ne pas oublier d'exécuter la requête et de retourner le résultat !
    return mysqli_query($conn, $sql);
}

function add_level_to_user($conn, $id_user, $level_file_to_add) {
    $user = get_user_by_id($conn, $id_user);
    
    if ($user) {
        // 1. Ensure we retrieve the inventory as a PHP array
        $levels_data = is_string($user['levels']) ? json_decode($user['levels'], true) : $user['levels'];
        
        // 2. Initialize the "mes_niveaux" key if it doesn't exist
        if (!isset($levels_data['mes_niveaux']) || !is_array($levels_data['mes_niveaux'])) {
            $levels_data['mes_niveaux'] = [];
        }
        
        // 3. Verify the player doesn't already own the level
        if (!in_array($level_file_to_add, $levels_data['mes_niveaux'])) {
            $levels_data['mes_niveaux'][] = $level_file_to_add; 
            
            // --- FIX 1: Secure the coins value before passing it ---
            $db_money = get_pieces_user($conn, $id_user);
            $pieces = is_array($db_money) ? (isset($db_money['coins']) ? (int)$db_money['coins'] : (int)reset($db_money)) : (int)$db_money;

            // --- FIX 2: Pass $levels_data (Array) instead of encoding it to a string here ---
            // If update_user() runs array_map(), it needs the raw array. It likely handles the json_encode() internally.
            return update_user($conn, $id_user, $user['login'], $user['mdp'], $levels_data, $pieces);
        }
        
        return true; // Already owned = success
    }
    
    return false; // User not found
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
    return $rs[0]["pieces"];
    }


function add_pieces_user($conn, $id_user, $pieces_add){
    $pieces = get_pieces_user($conn, $id_user);

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