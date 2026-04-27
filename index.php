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
  /* Tes keyframes restent les mêmes */
  @keyframes pigeon-bourre {
    0% { left: -100px; top: 80%; transform: rotate(0deg) scale(1); }
    25% { left: 25vw; top: 40%; transform: rotate(-300deg) scale(1); }
    28% { left: 28vw; top: 35%; transform: rotate(-350deg) scale(0.8); }
    30% { left: 30vw; top: 30%; transform: rotate(-360deg) scale(1.4); } 
    33% { left: 33vw; top: 35%; transform: rotate(-360deg) scale(0.9); }
    35% { left: 35vw; top: 40%; transform: rotate(-360deg) scale(1); }   
    55% { left: 55vw; top: 75%; transform: rotate(-500deg) scale(1); }
    58% { left: 58vw; top: 78%; transform: rotate(-530deg) scale(0.8); } 
    60% { left: 60vw; top: 80%; transform: rotate(-540deg) scale(1.4); } 
    63% { left: 63vw; top: 78%; transform: rotate(-550deg) scale(0.9); } 
    65% { left: 65vw; top: 75%; transform: rotate(-550deg) scale(1); }   
    80% { left: 80vw; top: 40%; transform: rotate(-700deg) scale(1); }
    83% { left: 83vw; top: 35%; transform: rotate(-710deg) scale(0.8); } 
    85% { left: 85vw; top: 30%; transform: rotate(-720deg) scale(1.4); } 
    88% { left: 88vw; top: 35%; transform: rotate(-720deg) scale(0.9); } 
    90% { left: 90vw; top: 40%; transform: rotate(-720deg) scale(1); }   
    100% { left: 120vw; top: 90%; transform: rotate(-600deg) scaleX(2) scale(1); }
  }

/* Nouvelle animation pour faire trembler l'écran */
  @keyframes shake-page {
    0% { transform: translate(2px, 1px) rotate(0deg); }
    10% { transform: translate(-2px, -2px) rotate(-1deg); }
    20% { transform: translate(-3px, 0px) rotate(1deg); }
    30% { transform: translate(0px, 3px) rotate(0deg); }
    40% { transform: translate(1px, -1px) rotate(1deg); }
    50% { transform: translate(-2px, 2px) rotate(-1deg); }
    60% { transform: translate(-3px, 1px) rotate(0deg); }
    70% { transform: translate(2px, 1px) rotate(-1deg); }
    80% { transform: translate(-1px, -2px) rotate(1deg); }
    90% { transform: translate(2px, 2px) rotate(0deg); }
    100% { transform: translate(1px, -2px) rotate(-1deg); }
  }

  /* La classe qui sera ajoutée au body au moment du pop */
  .shake-active {
    animation: shake-page 0.3s cubic-bezier(.36,.07,.19,.97) both;
  }

  #oiseau {
    position: fixed;
    /* On le place à sa position de départ, il attend sagement */
    left: -100px; 
    top: 80%;
  }

  /* La classe magique qui sera ajoutée au clic */
  .vole-pigeon {
    animation: pigeon-bourre 5s ease-in-out forwards;
  }
</style>

<script>
  const sfxPop = new Audio('https://www.myinstants.com/media/sounds/fahhhhhhhhhhhhhh.mp3');

  function faireTrembler() {
    const page = document.body;
    // On retire la classe au cas où elle y serait déjà
    page.classList.remove('shake-active');
    
    // ASTUCE : On demande au navigateur de recalculer la page. 
    // Ça permet de "reset" l'animation pour qu'elle puisse se rejouer tout de suite.
    void page.offsetWidth; 
    
    // On remet la classe pour lancer le tremblement
    page.classList.add('shake-active');
  }

  function jouerPopEtTrembler() {
    // 1. On joue le son
    let sfx = sfxPop.cloneNode();
    sfx.volume = 0.7;
    sfx.play(); 
    
    // 2. On fait trembler la page en même temps
    faireTrembler();
  }

  function lancerAnimation() {
    const pigeon = document.getElementById('oiseau');
    
    // On lance le visuel du pigeon
    pigeon.classList.add('vole-pigeon');

    // On programme le combo (Son + Tremblement) aux millisecondes près
    setTimeout(jouerPopEtTrembler, 1500); 
    setTimeout(jouerPopEtTrembler, 3000); 
    setTimeout(jouerPopEtTrembler, 4250); 
  }

  // On attend un clic n'importe où sur la page
  document.addEventListener('click', function onClickPage() {
    lancerAnimation();
    
    // On détruit l'événement juste après pour que ça ne se joue qu'une seule fois
    document.removeEventListener('click', onClickPage);
  });
</script>

</main> 

    <footer>
        <p>&copy; 2026 ARCH JS Team - Tout droit réservé</p>
    </footer>

    <!-- <script src="maindos/AppBundle/main.js"></script> -->
</body>
</html>