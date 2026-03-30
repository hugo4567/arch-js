<?php
// FICHIER POUR DES FONCTIONS AUXILLIAIRES LIER A LEVEL
function print_level($conn, $id)
{
    if (isset($id)) 
    {
        $my_level = get_level_by_id($conn, $id);
        if ($my_level)
        {
            echo "Nom : " . $my_level['name'] . "<br>";
            echo "Type : " . $my_level['type'] . "<br>";
            echo "Nombre de parties : " . $my_level['nb_play'] . "<br>";
        } else 
        {
            echo "Niveau introuvable.<br>";
        }
    }
}

?>