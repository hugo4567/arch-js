<?php
session_start(); 

// Dire au site que cest du JSON
header('Content-Type: application/json');
ini_set('display_errors', 0); 
error_reporting(E_ALL);

require_once __DIR__ . "/../DB/db_connect.php";
require_once __DIR__ . "/../CRUD/user.crud.php";
require_once __DIR__ . "/../CRUD/CRUD_score.php";
require_once __DIR__ . "/../CRUD/levels.crud.php";






//VERIF DATA
if (isset($_POST['coins'], $_SESSION['id_user'])) {
    
    $totalCoins = (int)$_POST['coins'];
    $userId = $_SESSION['id_user'];
    $className ='Niveau_demo_Pour_oral';

    // maj pieces
    $res = add_pieces_user($conn, $userId, $totalCoins);

    // Récupération du niveau
    if (!function_exists('get_all_levels_by_name')) {
        error_log('sauvegarder_score.php: function get_all_levels_by_name not found');
        echo json_encode(["status" => "error", "message" => "Erreur serveur : fonction manquante." ]);
        exit;
    }
    $ret = get_all_levels_by_name($conn, $className);

    // score et niveau
    if ($ret && isset($ret[0]['id'])) {
        $idlevel = $ret[0]['id'];
        $scoreCreated = create_score($conn, $userId, $totalCoins, $idlevel);
        
        echo json_encode([
            "status" => "success", 
            "message" => "Score enregistré pour le niveau ID $idlevel"
        ]);
    } else {
        $scoreCreated = create_score($conn, $userId, $totalCoins, 63);
        // Erreur si ca existe pas
        echo json_encode([
            "status" => "error", 
            "message" => "Niveau inconnu en BDD : " . $className
        ]);
    }
} else {
    
    echo json_encode([
        "status" => "error", 
        "message" => "Données manquantes ou utilisateur non connecté."
    ]);
}
exit; // On s'assure que rien d'autre n'est envoyé après car on est dans un contexte d'API qui doit répondre strictement en JSON
