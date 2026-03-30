<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Infos & Contact - PIXEL BLASTER</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles spécifiques pour la page Infos */
        .info-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .info-block {
            background: white;
            border: 6px solid #3498db; /* Bleu pour les infos */
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            color: #333;
            box-shadow: 0 8px 0 rgba(0,0,0,0.1);
        }

        .info-block h2 {
            font-family: 'Press Start 2P', cursive;
            font-size: 1.2rem;
            color: #3498db;
            margin-top: 0;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .member-card {
            background: #f9f9f9;
            border: 3px solid #eee;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
        }

        .member-card img {
            width: 80px;
            height: 80px;
            background: #ddd;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .contact-link {
            display: flex;
            align-items: center;
            background: #f1c40f;
            color: black;
            padding: 15px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 10px;
            transition: 0.2s;
        }

        .contact-link:hover {
            transform: scale(1.02);
            background: #f39c12;
        }

        .contact-icon {
            margin-right: 15px;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">PIXEL BLASTER</div>
        <ul>
            <li><a href="index.php">Retour à l'accueil</a></li>
        </ul>
    </nav>

    <div class="info-container">
        
        <section class="info-block">
            <h2>Le Projet</h2>
            <p><strong>PIXEL BLASTER ADVENTURE 2</strong> est un moteur de jeu de plateforme développé en JavaScript. Notre but est de permettre à chacun de créer, partager et jouer à des niveaux inspirés des classiques du genre.</p>
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
                    <p>Pixel Master</p>
                </div>
                <div class="member-card">
                    <div class="member-avatar">🎹</div>
                    <strong>Audio Design</strong>
                    <p>Bleep Bloop</p>
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