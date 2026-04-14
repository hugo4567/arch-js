<?php

$path_json = "/../../levels";

function save_level($id, $contenu){

    $nom = "$id.json";

    file_put_contents($nom, $contenu);
}


function get_level_by_id($id){
    
}

?>

/*
{
  "Name": "Paff",
  "Gravity": 20
}
*/