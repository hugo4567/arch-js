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
  @keyframes wtf-traverse {
    0%   { left: -100px; top: 120%; transform: scale(0.1) rotate(0deg) skew(0deg); filter: hue-rotate(0deg) invert(0%); }
    15%  { left: 30vw; top: 10%; transform: scale(5) rotate(720deg) skew(45deg); filter: hue-rotate(90deg) invert(100%); }
    30%  { left: 80vw; top: 90%; transform: scale(0.5) rotate(-1080deg) skew(-50deg); filter: hue-rotate(180deg) blur(10px); }
    45%  { left: 10vw; top: -20%; transform: scale(1) rotateX(1440deg) rotateY(720deg); filter: drop-shadow(20px 20px 50px red) sepia(100%); }
    60%  { left: 50vw; top: 50%; transform: scale(15) rotate(42069deg); filter: contrast(500%) saturate(1000%); }
    85%  { left: 120vw; top: 110%; transform: scaleX(-2) rotate(42deg); filter: hue-rotate(360deg); }
    100% { left: 50vw; top: -500px; transform: scale(0.01) rotate(0deg); filter: blur(50px) opacity(0); }
  }

  /* Bonus : un petit clignotement pour ruiner la rétine */
  @keyframes epilespy-mode {
    0%, 100% { mix-blend-mode: normal; }
    50% { mix-blend-mode: difference; }
  }

  #oiseau {
    position: fixed; /* Essentiel pour qu'il traverse bien l'écran */
    will-change: transform, left, top, filter; /* Pour que le navigateur ne décède pas */
    
    /* 1.2s : c'est 2x plus rapide.
      cubic-bezier(...) : ça lui donne un effet de rebond démoniaque.
      infinite alternate : il fait l'aller-retour à l'infini.
    */
    animation: 
      wtf-traverse 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite alternate,
      epilespy-mode 0.05s infinite;
      
    z-index: 9999;
  }
</style>
</main> 

    <footer>
        <p>&copy; 2026 ARCH JS Team - Tout droit réservé</p>
    </footer>

    <!-- <script src="maindos/AppBundle/main.js"></script> -->
</body>
</html>