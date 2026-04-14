<?php
session_start();
// Debugging (à enlever une fois le site en ligne)
ini_set('display_errors', '1');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>VOS TOPS SCORES</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>

<?php
$text = "<table id='scores' class='scores'>";
$text .= "<tr><th>Joueur</th><th>Score</th></tr>";
$text .=    "<tr><td>HUGO</td><td>12000</td></tr>";
$text .=    "<tr><td>MAXIME</td><td>-390</td></tr>";
$text .=  "</table>";
echo($text);
?>