<?php

$path_json = "/../../levels";
$nom_fichier_form = "niveau_json";

function save_level_json($id){
    global $nom_fichier_form;

    $nom = "$id.json";
    $contenu = file_get_contents($_FILES[$nom_fichier_form]['tmp_name']);

    file_put_contents($nom, $contenu);
}


function get_level_by_id_json($id){
    global $path_json;
    $nom = "$id.json";

    $contenu = file_get_contents($path_json . $nom);

    if ($contenu !== false) {
        return $contenu;
    } else {
    echo "Erreur lors de la lecture du fichier $nom.";
}
}


function get_all_levels_json(){ // return an array of json files.
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
    $nom = "$id.json";

    return unlink($path_json . $nom);
}

?>

/*
{
  "Name": "Paff",
  "Gravity": 20
}
*/