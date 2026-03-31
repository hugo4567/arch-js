<?php
session_start();
// Debugging (à enlever une fois le site en ligne)
ini_set('display_errors', '1');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>PIXEL BLASTER ADVENTURE - Accueil</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>

    <nav>
        <div class="logo">PIXEL BLASTER</div>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="login.php">Connexion / Login</a></li>
        </ul>
    </nav>

    <header>
        <h1>Bienvenue sur la Page du Projet</h1>
        <p>Le futur du jeu de plateforme rétro.</p>
    </header>

    <main>
        <section class="tabs-container">
            
            <div class="tab">
                <h3>Infos & Contact</h3>
                <p>&nbsp;Découvrez notre équipe et les détails du projet.</p>
                <a href="info.php" class="btn">Voir les infos</a>
            </div>

            <div class="tab">
                <h3>Jouer au Jeu</h3>
                <p>&nbsp;Lancez l'aventure directement dans votre navigateur.</p>
                <form action="login.php" method="POST">
                    <a href="maindos/AppBundle/index.html" class="bouton-jeu">Jouer au jeu</a>
                </form>
            </div>

            <div class="tab">
                <h3>Marketplace</h3>
                <p>&nbsp;Parcourez les niveaux créés par la communauté.</p>
                <form action="login.php" method="POST">
                    <a href="maindos/market.php"> INDEX Market</a>
                </form>
            </div>

            <div class="tab">
            <h3>Espace Créateur</h3>
                <p>&nbsp;Créez vos propres niveaux et partagez-les.</p>
                <form action="login.php" method="POST">
                    <a href="./login.php">Créer un niveau</a>
                </form>
            </div>

            <iframe 
    src="https://ex-a01.github.io/ARCH-JS//index.html" 
    width="960" 
    height="600" 
    style="border: none;" 
    allow="autoplay; fullscreen;" 
    allowfullscreen>
</iframe>


        </section>
    </main>

    <footer>
        <p>&copy; 2026 ARCH JS Team - Tout droit réservé</p>
    </footer>


    <script src="maindos/AppBundle/main.js"></script>
    <a href="maindos/AppBundle/index.html"> INDEX JEU</a>
    <a href="maindos/editor.html"> INDEX editor</a>
    <a href="maindos/index.html"> INDEX autre</a>
    <a href="maindos/market.html"> INDEX Market</a>
</body>
</html>