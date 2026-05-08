<?php
// On charge la connexion à la base de données et les fonctions CRUD (le Modèle)
// Utilisation de __DIR__ pour s'assurer que le chemin est toujours correct depuis ce fichier
require_once __DIR__ . '/Backend/DB/db_connect.php';
require_once __DIR__ . '/Backend/CRUD/levels.crud.php';
require_once __DIR__ . '/Backend/CRUD/get.json.php';

session_start();

if(!isset($_SESSION["admin"]))
{
    header("Location: login.php");
}

// On détermine quelle action l'utilisateur veut effectuer. 
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch ($action) {
        case 'add':
        // 1. Si le formulaire a été soumis (clic sur le bouton enregistrer -> POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // J'ai DÉCOMMENTÉ l'appel à la fonction pour que ça ajoute vraiment en BDD
            $id_level = create_level($conn, $_POST['name'], $_POST['type'], $_POST['id_crea'], $_POST['level'], $_POST['nb_play'], $_POST['note_pos'], $_POST['note_neg']);
            // on recupère l'id du level qu'on vient d'ajouter

            if ($id_level){
                save_level_json($id_level); // NE FONCTIONNE PAS ???
            } else {

            }


            // On redirige vers la liste une fois l'ajout terminé
            header('Location: AdminPannel.php');
            exit;
        }
        
        // 2. Si on arrive simplement sur la page (clic sur le lien -> GET)
        $level_data = null;
        require __DIR__ . '/Backend/views/form.view.php';
        break;
    case 'edit':
        $id = (int)$_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            update_level($conn, $id, $_POST['name'], $_POST['type'], $_POST['id_crea'], $_POST['level'], $_POST['nb_play'], $_POST['note_pos'], $_POST['note_neg']);
            
            // CORRECTION : Redirection
            header('Location: AdminPannel.php');
            exit;
        }
        
        $level_data = get_level_by_id($conn, $id);
        require __DIR__ . '/Backend/views/form.view.php';
        break;

    case 'delete':
        $id = (int)$_GET['id'];
        
        delete_level($conn, $id);
        
        // CORRECTION : Redirection
        header('Location: AdminPannel.php');
        exit;

    case 'list':
    default:
        $levels = get_all_level($conn);
        
        // CORRECTION : On charge level.view.php et non form.view.php
        require __DIR__ . '/Backend/views/level.view.php';
        break;
}
?>