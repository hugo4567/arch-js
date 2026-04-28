<?php
session_start();
// Debugging, on peut garder stv
ini_set('display_errors', '1');
error_reporting(E_ALL);
require_once __DIR__ . '/Backend/CRUD/user.crud.php';
require_once __DIR__ . '/Backend/DB/db_connect.php';
require_once __DIR__ . '/Backend/CRUD/CRUD_score.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>VOS TOPS SCORES</title>
    <link rel="stylesheet" href="style.css"> </head>
<body class="page-scoreboard">
    <?php include 'navbar.php'; ?>


<video autoplay muted loop playsinline class="bg-video">
    <source src="img/background.mp4" type="video/mp4">
</video>
<?php

$view = $_GET['view'] ?? 'scores';
$allowed = ['scores','players','levels'];

if (!in_array($view, $allowed)) {
    $view = 'scores';
}
$views_order = $allowed;

if ($view === 'levels') {
echo'<h1> Les tops scores des joueurs en fonction de leur top niveau</h1>';
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
$i = array_search($view, $views_order);
    $next = $views_order[($i + 1) % count($views_order)];
    echo "<p><a href='?view=$next' class='hugob'>Suivant</a></p>";
}
?>

<?php



if ($view === 'scores') {
echo"<h1> HAll of fame des niveaux </h1>";
$scores = get_total_scores_by_level($conn);

$text = "<table id='scores' class='scores'>";
$text .= "<thead><tr><th>Niveau</th><th>Score</th></tr></thead>";
$text .= "<tbody>";

foreach($scores as $score) {
    $text .= "<tr>";
    $text .= "<td>" . $score['niveau'] . "</td>";
    $text .= "<td>" . $score['total_score'] . "</td>";
    $text .= "</tr>";
}

$text .= "</tbody></table>";
echo($text);
$i = array_search($view, $views_order);
    $next = $views_order[($i + 1) % count($views_order)];
    echo "<p><a href='?view=$next' class='hugob'>Suivant</a></p>";
}
?>



<?php
if ($view === 'players') {
echo'<h1> Les joueurs avec le plus de scores totaux </h1>';
$scores = get_total_scores_by_player($conn);

$text = "<table id='scores' class='scores'>";
$text .= "<thead><tr><th>Joueur</th><th>Niveau</th></tr></thead>";
$text .= "<tbody>";

foreach($scores as $score) {
    $text .= "<tr>";
    $text .= "<td>" . $score['joueur'] . "</td>";
    $text .= "<td>" . $score['total_score'] . "</td>";
    $text .= "</tr>";
}

$text .= "</tbody></table>";
echo($text);
$i = array_search($view, $views_order);
    $next = $views_order[($i + 1) % count($views_order)];
    echo "<p><a href='?view=$next' class='hugob'>Suivant</a></p>";
}
?>
<?php
require_once __DIR__ . "/Backend/DB/db_disconnect.php";
?>
