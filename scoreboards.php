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
$text = "<table id='scores' class='scores'> 
    <tr><th>Joueur</th><th>Score</th></tr>
    <tr><td>Alice</td><td>120</td></tr>
    <tr><td>Bob</td><td>95</td></tr>
  </table>;
echo($text);
?>