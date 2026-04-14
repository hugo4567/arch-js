<?php

$path_json = "/../../levels";

function save_level($id, $contenu){

    $nom = "$id.json";

    file_put_contents($nom, $contenu);
}


function get_level_by_id($id){
    global $path_json;
    $nom = "$id.json";

    $contenu = file_get_contents($path_json . $nom);

    if ($contenu !== false) {
        return $contenu;
    } else {
    echo "Erreur lors de la lecture du fichier $nom.";
}
}


function get_all_levels(){ // return an array of json files.
    global $path_json;
    $contenus_json = [];
    $fichiers = scandir($path_json);

    for ($i = 0; $i < count($fichiers); $i++){
        $contenu = file_get_contents($fichiers[$i]);

        if ($contenu !== false) {
            $contenus_json[] = $contenu;
        } else {
            echo "Erreur lors de la lecture du fichier $fichiers[$i]";
        }
    }

    return $contenus_json;
}

function delete_file($id){
    global $path_json;

    if (unlink($if ($path_json . $nom)){
        echo "Le fichier a été supprimé avec succès.";
    } else {
        echo "Erreur : Impossible de supprimer le fichier.";
    })) {
        echo "Le fichier a été supprimé avec succès.";
    } else {
        echo "Erreur : Impossible de supprimer le fichier.";
    }
}

?>

/*
{
  "Name": "Paff",
  "Gravity": 20
}
*/