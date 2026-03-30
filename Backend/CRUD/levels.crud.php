<?php
// --- 1. CREATE ---
function create_level($conn, $name, $type, $id_crea, $level, $nb_play, $note_pos, $note_neg) {
    // Sécurisation des données
    $name = mysqli_real_escape_string($conn, $name);
    $type = (int)$type;
    $id_crea = (int)$id_crea;
    $level = (int)$level;
    $nb_play = (int)$nb_play;
    $note_pos = (int)$note_pos;
    $note_neg = (int)$note_neg;

    $sql = "INSERT INTO levels (name, type, id_crea, level, nb_play, note_pos, note_neg) 
            VALUES ('$name', $type, $id_crea, $level, $nb_play, $note_pos, $note_neg)";
            
    return mysqli_query($conn, $sql); // Retourne true si succès, false sinon
}

// --- 2. READ (Tous les éléments) ---
function get_all_level($conn) {
    $sql = "SELECT * FROM levels ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    
    $levels = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $levels[] = $row;
        }
    }
    return $levels; // Retourne un tableau avec toutes les lignes
}

// --- 3. READ (Un seul élément par ID) ---
function get_level_by_id($conn, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM levels WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result); // Retourne la ligne sous forme de tableau associatif
    }
    return null; // Si non trouvé
}

// --- 4. UPDATE ---
function update_level($conn, $id, $name, $type, $id_crea, $level, $nb_play, $note_pos, $note_neg) {
    $id = (int)$id;
    $name = mysqli_real_escape_string($conn, $name);
    $type = (int)$type;
    $id_crea = (int)$id_crea;
    $level = (int)$level;
    $nb_play = (int)$nb_play;
    $note_pos = (int)$note_pos;
    $note_neg = (int)$note_neg;

    $sql = "UPDATE levels 
            SET name='$name', type=$type, id_crea=$id_crea, level=$level, nb_play=$nb_play, note_pos=$note_pos, note_neg=$note_neg 
            WHERE id=$id";

    return mysqli_query($conn, $sql);
}

// --- 5. DELETE ---
function delete_level($conn, $id) {
    $id = (int)$id;
    $sql = "DELETE FROM levels WHERE id=$id";
    
    return mysqli_query($conn, $sql);
}
?>