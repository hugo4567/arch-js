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
    
}

?>

/*
{
  "Name": "Paff",
  "Gravity": 20
}
*/