<?php

$path_json = "/../../levels";

function save_level($id, $contenu){

    $nom = "$id.json";

    file_put_contents($nom, $contenu);
}


function get_level_by_id($id){
    $nom = "$id.json";

    $contenu = file_get_contents($nom);

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
            $contenus_json[] = 
        } else {
            echo "Erreur lors de la lecture du fichier $fichiers[$i]";
        }
    }
}

?>

/*
{
  "Name": "Paff",
  "Gravity": 20
}
*/