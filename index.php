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
    0%   { left: -100px; top: 80%; transform: rotate(0deg) scale(1); }
    
    /* --- LOOPING & POP (20%) --- */
    18%  { left: 18vw; top: 32%; transform: rotate(-300deg) scale(1); }
    20%  { left: 20vw; top: 30%; transform: rotate(-360deg) scale(1.6); } /* POP ! */
    22%  { left: 22vw; top: 33%; transform: rotate(-360deg) scale(1); }
    
    /* --- CHUTE SUR LE DOS & POP (40%) --- */
    38%  { left: 33vw; top: 80%; transform: rotate(150deg) scaleY(-1) scale(1); }
    40%  { left: 35vw; top: 85%; transform: rotate(180deg) scaleY(-1) scale(1.6); } /* POP ! */
    42%  { left: 36vw; top: 84%; transform: rotate(178deg) scaleY(-1) scale(1); }
    
    /* --- FLOTTEMENT & POP (60%) --- */
    58%  { left: 39vw; top: 81%; transform: rotate(172deg) scaleY(-1) scale(1); }
    60%  { left: 40vw; top: 80%; transform: rotate(170deg) scaleY(-1) scale(1.6); } /* POP ! */
    62%  { left: 43vw; top: 73%; transform: rotate(150deg) scale(1); } /* Remis à l'endroit */
    
    /* --- PANIQUE & POP (80%) --- */
    78%  { left: 65vw; top: 15%; transform: rotate(40deg) scale(1); }
    80%  { left: 70vw; top: 10%; transform: rotate(45deg) scale(1.6); } /* POP ! */
    82%  { left: 75vw; top: 15%; transform: rotate(50deg) scale(1); }
    
    /* Crash final */
    100% { left: 120vw; top: 90%; transform: rotate(120deg) scaleX(2) scale(1); }
  }

  #oiseau {
    position: fixed;
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