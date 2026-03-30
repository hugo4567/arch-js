<?php
// --- 1. CREATE ---
function create_user($conn, $login, $mdp, $levels) {
    // Sécurisation des données
    $name = mysqli_real_escape_string($conn, $name);
    $type = (int)$type;
    $id_crea = (int)$id_crea;
    $user = (int)$user;
    $nb_play = (int)$nb_play;
    $note_pos = (int)$note_pos;
    $note_neg = (int)$note_neg;

    $sql = "INSERT INTO users (name, type, id_crea, user, nb_play, note_pos, note_neg) 
            VALUES ('$name', $type, $id_crea, $user, $nb_play, $note_pos, $note_neg)";
            
    return mysqli_query($conn, $sql); // Retourne true si succès, false sinon
}

// --- 2. READ (Tous les éléments) ---
function get_all_user($conn) {
    $sql = "SELECT * FROM users ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    
    $users = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users; // Retourne un tableau avec toutes les lignes
}

// --- 3. READ (Un seul élément par ID) ---
function get_user_by_id($conn, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result); // Retourne la ligne sous forme de tableau associatif
    }
    return null; // Si non trouvé
}

function get_user_by_name($conn, $name) {
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result); // Retourne la ligne sous forme de tableau associatif
    }
    return null; // Si non trouvé
}

function get_all_users_by_name($conn, $name) {
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = mysqli_query($conn, $sql);
    
    $users = []; // On prépare un tableau vide
    
    if ($result && mysqli_num_rows($result) > 0) {
        // La boucle va piocher CHAQUE résultat trouvé
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row; // On ajoute la ligne au tableau global
        }
    }
    return $users; // Retourne un tableau contenant les 3 niveaux (ou un tableau vide)
}

// --- 4. UPDATE ---
function update_user($conn, $id, $name, $type, $id_crea, $user, $nb_play, $note_pos, $note_neg) {
    $id = (int)$id;
    $name = mysqli_real_escape_string($conn, $name);
    $type = (int)$type;
    $id_crea = (int)$id_crea;
    $user = (int)$user;
    $nb_play = (int)$nb_play;
    $note_pos = (int)$note_pos;
    $note_neg = (int)$note_neg;

    $sql = "UPDATE users 
            SET name='$name', type=$type, id_crea=$id_crea, user=$user, nb_play=$nb_play, note_pos=$note_pos, note_neg=$note_neg 
            WHERE id=$id";

    return mysqli_query($conn, $sql);
}

// --- 5. DELETE ---
function delete_user($conn, $id) {
    $id = (int)$id;
    $sql = "DELETE FROM users WHERE id=$id";
    
    return mysqli_query($conn, $sql);
}
?>