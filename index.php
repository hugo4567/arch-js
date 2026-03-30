<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>
<!DOCTYPE html>
<meta-charset = utf8> </meta-charset>
<html>
    <head>
        <title>PIXEL BLASTER ADVENTURE 2</title>
    </head>
    <body>
    
    <nav>
        <a href="admin_joueur.php">Joueurs</a>
        <a href="admin_partie.php">Parties</a>
        <?php if (isset($_SESSION["admin"])): ?>
            <a href="index.php?action=disconnect">Déconnexion</a>
        <?php endif; ?>
    </nav>
    </body>
</html>
<script> src="maindos/main.js"</script>
<script> src="maindos/AppBundle/main.js"</script>

<a href=login.php >login</a>