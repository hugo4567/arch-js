<?php

require __DIR__ . '/../CRUD/user.crud.php';
function user_auth($conn, $login_auth, $mdp_auth){ // Pas safe, mais ça marche.
    $auth = false;
    $res_db = select_user_login($conn, $login_auth);

    if($res_db){
        if ($mdp_auth == $res_db[0]['mdp']){
            $auth = true;
        }
    }

    return $auth;
}

?>