<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>PIXEL BLASTER ADVENTURE 2</title>
    </head>
<body>

    <nav>
        <a href="login.php">Page de login</a>
    </nav>

    <main>
        <h1>Page du Projet</h1>

        <section class="form-container">
            
            <form action="login.php" method="POST" style="display:inline;">
                <button type="submit" name="action" value="jeu">Jouer (Game running)</button>
            </form>

            <form action="login.php" method="POST" style="display:inline;">
                <button type="submit" name="action" value="market">Marketplace / Posts</button>
            </form>

            <form action="login.php" method="POST" style="border: 1px solid #000; padding: 10px; margin-top: 20px;">
                <h3>Accès Admin</h3>
                <input type="text" name="login" placeholder="Admin User">
                <input type="password" name="passwd" placeholder="Password">
                <button type="submit" name="action" value="admin">Connexion Panel Admin</button>
            </form>

        </section>
    </main>

    <script src="maindos/main.js"></script>
    <script src="maindos/AppBundle/main.js"></script>
</body>
</html>