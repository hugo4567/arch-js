<?php
// On n'utilise PAS l'URL de phpMyAdmin ici
$serveur = "127.0.0.1"; // Au lieu de "localhost"$utilisateur = "grp1";
$mot_de_passe = "Exoo2zoa";
$base_de_donnees = "db_grp1";

// Connexion
$conn = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérification de la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
?>