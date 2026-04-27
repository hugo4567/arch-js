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
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
</head>
<body class="page-index">

    <video autoplay muted loop playsinline class="bg-video">
        <source src="img/background.mp4" type="video/mp4">
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
            <p>&nbsp;Découvrez notre équipe et les détails du projet.</p>
            <a href="info.php" class="btn">Voir les infos</a>
        </div>

        <img id="oiseau" src="img/ralpha.png" style="position:fixed; left:-100px; top:80%; width:80px; z-index:9999;">

        <div class="tab">
            <h3>Jouer au Jeu</h3>
            <p>&nbsp;Lancez l'aventure directement dans votre navigateur.</p>
            <form action="login.php" method="POST">
                <a href="GamePage.php" class="bouton-jeu">Jouer au jeu</a>
            </form>
        </div>

        <div class="tab">
            <h3>Marketplace</h3>
            <p>&nbsp;Parcourez les niveaux créés par la communauté.</p>
            <form action="login.php" method="POST">
                <a href="market.php"> INDEX Market</a>
            </form>
        </div>

        <div class="tab">
            <h3>Espace Créateur</h3>
            <p>&nbsp;Créez vos propres niveaux et partagez-les.</p>
            <form action="login.php" method="POST">
                <a href="./login.php">Créer un niveau</a>
            </form>
        </div>

        <div class="tab">
            <h3>Espace Scores</h3>
            <p>&nbsp;CHECK MOI LES SCORES, DEVENEZ LE BEST.</p>
            <form action="scoreboards.php" method="POST">
                <a href="./scoreboards.php">WELCOME</a>
            </form>
        </div>

    </section>
    
<style>
  @keyframes pigeon-bourre {
    /* Décollage normal */
    0%   { left: -100px; top: 80%; transform: rotate(0deg); }
    
    /* Pète la forme, fait un looping au calme */
    20%  { left: 20vw; top: 30%; transform: rotate(-360deg); }
    
    /* Oublie soudainement comment voler, tombe sur le dos */
    40%  { left: 35vw; top: 85%; transform: rotate(180deg) scaleY(-1); }
    
    /* Petit moment de flottement en mode "où suis-je ?" */
    60%  { left: 40vw; top: 80%; transform: rotate(170deg) scaleY(-1); }
    
    /* Grosse panique, repart en flèche vers le haut */
    80%  { left: 70vw; top: 10%; transform: rotate(45deg); }
    
    /* Se prend un mur invisible et s'écrase vers le bas, tout allongé */
    100% { left: 120vw; top: 90%; transform: rotate(120deg) scaleX(2); }
  }

  #oiseau {
    position: fixed;
    /* On passe sur 5 secondes pour avoir le temps de voir l'action */
    /* ease-in-out donne un effet naturel d'accélération et de décélération entre chaque étape */
    animation: pigeon-bourre 5s ease-in-out forwards;
  }
</style>

</main> 

    <footer>
        <p>&copy; 2026 ARCH JS Team - Tout droit réservé</p>
    </footer>

    <!-- <script src="maindos/AppBundle/main.js"></script> -->
</body>
</html>