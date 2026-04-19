<?php
session_start();
// Debugging
ini_set('display_errors', '1');
error_reporting(E_ALL);
require_once __DIR__ . '/Backend/CRUD/user.crud.php';
require_once __DIR__ . '/Backend/DB/db_connect.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>VOS TOPS SCORES</title>
    <link rel="stylesheet" href="style.css"> </head>
<body class="page-scoreboard">

<?php

$text = "<table id='scores' class='scores'>";
$text .= "<th>";
foreach(get_all_users($conn) as $user) {
    $text .= "<tr>". $user['nom'] . "</tr><tr>" . $user['Score'] . "</tr></th>";

$text .=    "<tr><td>HUGO</td><td>12000</td></tr>";
$text .=    "<tr><td>MAXIME</td><td>-390</td></tr>";
$text .=  "</table>";
echo($text);
}

?>

<?php
require_once __DIR__ . "/Backend/DB/db_disconnect.php";
echo("a");
?>