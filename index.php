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
</head>
<body class="page-index">

    <video autoplay muted loop playsinline class="bg-video">
        <source src="ton-fichier-video.mp4" type="video/mp4">
    </video>

    <?php include 'navbar.php'; ?>

    <header>
        <h1>PIXEL BLASTER ADVENTURE</h1>
        <p>Le futur du jeu de plateforme rétro.</p>
    </header>

    <main>
        <section class="tabs-container">
            
            <div class="tab">
                <h3>Infos & Contact</h3>
                <p>Découvrez notre équipe et les détails du projet.</p>
                <a href="info.php" class="btn">Voir les infos</a>
            </div>

            <div class="tab">
                <h3>Jouer au Jeu</h3>
                <p>Lancez l'aventure directement dans votre navigateur.</p>
                <a href="GamePage.php" class="bouton-jeu">Jouer au jeu</a>
            </div>

            <div class="tab">
                <h3>Marketplace</h3>
                <p>Parcourez les niveaux créés par la communauté.</p>
                <a href="market.php">INDEX Market</a>
            </div>

            <div class="tab">
                <h3>Espace Créateur</h3>
                <p>Créez vos propres niveaux et partagez-les.</p>
                <a href="./login.php">Créer un niveau</a>
            </div>

            <div class="tab">
                <h3>Espace Scores</h3>
                <p>CHECK MOI LES SCORES, DEVENEZ LE BEST.</p>
                <a href="./scoreboards.php">WELCOME</a>
            </div>

            <div class="tab">
                <h3>Liste Niveaux</h3>
                <p>KILLIAN REGARDE.</p>
                <a href="./lister_json.php">MAXIME REGARDE</a>
            </div>

        </section>
    </main>

    <footer>
        <p>&copy; 2026 ARCH JS Team - Tout droit réservé</p>
    </footer>

    <script src="maindos/AppBundle/main.js"></script>
</body>
</html>