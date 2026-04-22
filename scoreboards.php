<?php
session_start();
// Debugging
ini_set('display_errors', '1');
error_reporting(E_ALL);
require_once __DIR__ . '/Backend/CRUD/user.crud.php';
require_once __DIR__ . '/Backend/DB/db_connect.php';
require_once __DIR__ . '/CRUD_score.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>VOS TOPS SCORES</title>
    <link rel="stylesheet" href="style.css"> </head>
<body class="page-scoreboard">

<?php

$scores = get_all_scores_with_details($conn);

$text = "<table id='scores' class='scores'>";
$text .= "<thead><tr><th>Joueur</th><th>Niveau</th><th>Score</th></tr></thead>";
$text .= "<tbody>";

foreach($scores as $score) {
    $text .= "<tr>";
    $text .= "<td>" . $score['joueur'] . "</td>";
    $text .= "<td>" . $score['niveau'] . "</td>";
    $text .= "<td>" . $score['score'] . "</td>";
    $text .= "</tr>";
}

$text .= "</tbody></table>";
echo($text);

?>

<?php
require_once __DIR__ . "/Backend/DB/db_disconnect.php";
echo("a");
?>
