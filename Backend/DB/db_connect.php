<?php

error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_OFF);
$serveur = "localhost"; 
// Si localhost ne marche pas, faut mettre 127.0.0.1

$utilisateur = "grp1";
$mot_de_passe = "Exoo2zoa";
$base_de_donnees = "db_grp1";
$conn = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees, 3306);

if (null == $conn){
    error_log("DB connect error: " . mysqli_connect_error());
}
else{
    mysqli_set_charset($conn, "utf8");
}//langue de communication
?>