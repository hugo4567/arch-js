<?php
// --- 1. CREATE ---
function create_user($conn, $login, $mdp, $levels) {
    // Sécurisation des données
    $login = mysqli_real_escape_string($conn, $login);
    $mdp = mysqli_real_escape_string($conn, $mdp); 
    $levels = (int)$levels;

    $sql = "INSERT INTO users (login, mdp, levels) 
            VALUES ('$login', '$mdp', $levels)";
            
    return mysqli_query($conn, $sql); // Retourne true si succès, false sinon
}

// --- 2. READ (Tous les éléments) ---
function get_all_users($conn) {
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

// --- 3. READ (Un seul élément par ID ou Login) ---
function get_user_by_id($conn, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result); 
    }
    return null; // Si non trouvé
}

function get_user_by_login($conn, $login) {
    $login = mysqli_real_escape_string($conn, $login);
    $sql = "SELECT * FROM users WHERE login = '$login'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result); 
    }
    return null; // Si non trouvé
}

// --- 4. UPDATE ---
function update_user($conn, $id, $login, $mdp, $levels) {
    $id = (int)$id;
    $login = mysqli_real_escape_string($conn, $login);
    $mdp = mysqli_real_escape_string($conn, $mdp);
    $levels = (int)$levels;

    $sql = "UPDATE users 
            SET login='$login', mdp='$mdp', levels=$levels 
            WHERE id=$id";

    return mysqli_query($conn, $sql);
}

// --- 5. DELETE ---
function delete_user($conn, $id) {
    $id = (int)$id;
    $sql = "DELETE FROM users WHERE id=$id";
    
    return mysqli_query($conn, $sql);
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

function creer_rs($query){
    $rs = [];

    while ($row = mysqli_fetch_assoc($query)){
        $rs[] = $row;
    }

    return $rs;
}

?>