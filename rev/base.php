<?php
session_start();
// Debugging
ini_set('display_errors', '1');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>PIXEL BLASTER ADVENTURE - Accueil</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="shortcut icon" type="image/png" href="img/rachid.png"/>
</head>

<body class="page-index">

    <video autoplay muted loop playsinline class="bg-video">
        <source src="img/background.mp4" type="video/mp4">
    </video>

    <?php include 'navbar.php'; ?>

    <header>
        <h1>PIXEL BLASTER ADVENTURE</h1>
        <p>Le futur du jeu de plateforme collaboratif.</p>
    </header>

    <main>
        <section class="tabs-container">

            <div class="tab">
                <h3>Infos & Contact</h3>
                <p>&nbsp;Découvrez notre équipe et les détails du projet.</p>
                <a href="info.php" class="btn">Voir les infos</a>
            </div>

            <img id="oiseau" src="img/ralpha.png" style="position:fixed; left:-100px; top:80%; width:80px; z-index:9999;">

            <div class="tab"></div>
        </section>
    </main>
    <h1 > VENEZ NOMBREUX</h1>
    <p> ICI</p>
    <button class="btn" id="btn" > CLIKCL LE</button>
    <script src="base.js"></script>
    <div> TEXTE DE BASE>/div>
</body>
