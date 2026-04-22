<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Infos & Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-info">

    <?php include 'navbar.php'; ?>

    <div class="info-container">
        
        <section class="info-block">
            <h2>Le Projet</h2>
            <p><strong>PIXEL BLASTER ADVENTURE</strong> est un moteur de jeu de plateforme développé en JavaScript. Notre but est de permettre à chacun de créer, partager et jouer à des niveaux inspirés des classiques du genre.</p>
            <p>Version actuelle : <strong>1.0.1 (Beta)</strong></p>
        </section>

        <section class="info-block" style="border-color: #2ecc71;">
            <h2 style="color: #2ecc71;">Notre Team</h2>
            <div class="team-grid">
                <div class="member-card">
                    <div class="member-avatar">👤</div>
                    <strong>Développeur Lead</strong>
                    <p>ARCH JS</p>
                </div>
                <div class="member-card">
                    <div class="member-avatar">🎨</div>
                    <strong>Graphiste / DA</strong>
                    <p>Salvador Dalí</p>
                </div>
                <div class="member-card">
                    <div class="member-avatar">🎹</div>
                    <strong>Audio Design</strong>
                    <p>Ludwig van Beethoven</p>
                </div>
            </div>
        </section>

        <section class="info-block" style="border-color: #e74c3c;">
            <h2 style="color: #e74c3c;">Nous Contacter</h2>
            <p>Un bug ? Une suggestion ? Contactez-nous via nos réseaux :</p>
            
            <a href="mailto:contact@pixelblaster.com" class="contact-link">
                <span class="contact-icon">📧</span> Envoyer un Email
            </a>
            
            <a href="#" class="contact-link" style="background: #7289da; color: white;">
                <span class="contact-icon">💬</span> Rejoindre le Discord
            </a>

            <a href="https://github.com" class="contact-link" style="background: #333; color: white;">
                <span class="contact-icon">🐙</span> GitHub du Projet
            </a>
        </section>

    </div>

    <footer>
        <p>&copy; 2026 ARCH JS Team - Made with &hearts; for retro gaming</p>
    </footer>

</body>
</html>