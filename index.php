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
    /* Décollage */
    0% { left: -100px; top: 80%; transform: rotate(0deg) scale(1); }

    /* --- ACTE 1 : Le Looping (à 30%) --- */
    25% { left: 25vw; top: 40%; transform: rotate(-300deg) scale(1); }
    28% { left: 28vw; top: 35%; transform: rotate(-350deg) scale(0.8); } /* Squash (se contracte) */
    30% { left: 30vw; top: 30%; transform: rotate(-360deg) scale(1.4); } /* POP 1 ! */
    33% { left: 33vw; top: 35%; transform: rotate(-360deg) scale(0.9); } /* Rebond */
    35% { left: 35vw; top: 40%; transform: rotate(-360deg) scale(1); }   /* Stabilisation */

    /* --- ACTE 2 : Tombe sur le dos (à 60%) --- */
    55% { left: 55vw; top: 75%; transform: rotate(-500deg) scale(1); }
    58% { left: 58vw; top: 78%; transform: rotate(-530deg) scale(0.8); } /* Squash */
    60% { left: 60vw; top: 80%; transform: rotate(-540deg) scale(1.4); } /* POP 2 ! (totalement à l'envers) */
    63% { left: 63vw; top: 78%; transform: rotate(-550deg) scale(0.9); } /* Rebond */
    65% { left: 65vw; top: 75%; transform: rotate(-550deg) scale(1); }   /* Stabilisation */

    /* --- ACTE 3 : Fuite en panique (à 85%) --- */
    80% { left: 80vw; top: 40%; transform: rotate(-700deg) scale(1); }
    83% { left: 83vw; top: 35%; transform: rotate(-710deg) scale(0.8); } /* Squash */
    85% { left: 85vw; top: 30%; transform: rotate(-720deg) scale(1.4); } /* POP 3 ! (remis à l'endroit) */
    88% { left: 88vw; top: 35%; transform: rotate(-720deg) scale(0.9); } /* Rebond */
    90% { left: 90vw; top: 40%; transform: rotate(-720deg) scale(1); }   /* Stabilisation */

    /* --- CRASH FINAL --- */
    100% { left: 120vw; top: 90%; transform: rotate(-600deg) scaleX(2) scale(1); }
  }

  #oiseau {
    position: fixed;
    animation: pigeon-bourre 5s ease-in-out forwards;
  }
</style>

<script>
  // 1. On charge ton chef-d'œuvre sonore
  const sfxPop = new Audio('https://www.myinstants.com/media/sounds/fahhhhhhhhhhhhhh.mp3');

  // 2. La fonction pour jouer le son (avec clone pour gérer les superpositions)
  function jouerSfx() {
    let sfx = sfxPop.cloneNode();
    sfx.volume = 0.7; // Tu peux ajuster le volume entre 0.0 et 1.0
    
    // Le .catch permet d'éviter une erreur console si le navigateur bloque l'autoplay
    sfx.play().catch(err => console.log("Clic requis par le navigateur pour jouer le son :", err));
  }

  // 3. On déclenche les sons avec le timing parfait pour tes 5 secondes (5000ms)
  
  // POP 1 (30% de 5s)
  setTimeout(jouerSfx, 1500); 
  
  // POP 2 (60% de 5s)
  setTimeout(jouerSfx, 3000); 
  
  // POP 3 (85% de 5s)
  setTimeout(jouerSfx, 4250); 
</script>

</main> 

    <footer>
        <p>&copy; 2026 ARCH JS Team - Tout droit réservé</p>
    </footer>

    <!-- <script src="maindos/AppBundle/main.js"></script> -->
</body>
</html>