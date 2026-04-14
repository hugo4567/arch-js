<?php

require("/../CRUD/admin.crud.php");
function admin_auth($conn, $login, $mdp){ // Pas safe, mais ça marche.
    $auth = false;
    $res_db = select_admin_login($conn, $login);

    if($res_db){
        if ($mdp == $res_db['mdp']){
            $auth = true;
        }
    }

    return $auth;
}

?>