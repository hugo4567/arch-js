<?php

function admin_auth($conn, $login, $mdp){
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