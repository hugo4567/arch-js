<?php
// On charge la connexion à la base de données et les fonctions CRUD (le Modèle)
require_once './Backend/DB/db_connect.php';
require_once './Backend/CRUD/levels.crud.php';

// On détermine quelle action l'utilisateur veut effectuer. 
// Par défaut, s'il n'y a pas d'action dans l'URL, on affiche la liste ('list').
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch ($action) {
    case 'add':
        // Si le formulaire a été soumis en POST (clic sur le bouton enregistrer)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            create_level($conn, $_POST['name'], $_POST['type'], $_POST['id_crea'], $_POST['level'], $_POST['nb_play'], $_POST['note_pos'], $_POST['note_neg']);
            // On redirige vers l'accueil du panel admin après l'ajout
            header('Location: admin_panel.php');
            exit;
        }
        
        // Si on arrive juste sur la page d'ajout, on prépare des données vides
        $level_data = null; 
        
        // On charge la vue du formulaire
        require './Backend/views/form.view.php';
        break;

    case 'edit':
        $id = (int)$_GET['id'];
        
        // Si le formulaire de modification a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            update_level($conn, $id, $_POST['name'], $_POST['type'], $_POST['id_crea'], $_POST['level'], $_POST['nb_play'], $_POST['note_pos'], $_POST['note_neg']);
            header('Location: admin_panel.php');
            exit;
        }
        
        // On récupère les données du niveau spécifique pour pré-remplir le formulaire
        $level_data = get_level_by_id($conn, $id);
        
        // On charge la vue du formulaire (qui va utiliser $level_data)
        require './Backend/views/form.view.php';
        break;

    case 'delete':
        $id = (int)$_GET['id'];
        
        // On supprime et on redirige directement
        delete_level($conn, $id);
        header('Location: admin_panel.php');
        exit;

    case 'list':
    default:
        // On demande au modèle de récupérer tous les niveaux
        $levels = get_all_level($conn);
        
        // On charge la vue de la liste, qui aura maintenant accès au tableau $levels
        require './Backend/views/form.view.php';
        break;
}
?>