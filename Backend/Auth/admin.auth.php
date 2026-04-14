<?php

require __DIR__ . '/../CRUD/admin.crud.php';
function admin_auth($conn, $login_auth, $mdp_auth){ // Pas safe, mais ça marche.
    $auth = false;
    $res_db = select_admin_login($conn, $login_auth);

    if($res_db){
        if ($mdp_auth == $res_db[0]['mdp']){
            $auth = true;
        }
    }

    return $auth;
}

?>