<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
// On utilise l'hôte spécifique au réseau de l'IUT
$serveur = "127.0.0.1"; 
// SI localhost ne marche pas, essaie : "mariadb" ou "mysql" 
// selon si tu es dans un conteneur spécifique du département.

$utilisateur = "grp1";
$mot_de_passe = "Exoo2zoa";
$base_de_donnees = "db_grp1";

try {
    $conn = mysqli_connect("l1.dptinfo-usmb.fr", $utilisateur, $mot_de_passe, $base_de_donnees, 3306);
    mysqli_set_charset($conn, "utf8");
    // Si on arrive ici, c'est que c'est gagné !
} catch (mysqli_sql_exception $e) {
    echo "Détail de l'erreur : " . $e->getMessage();
}
?>