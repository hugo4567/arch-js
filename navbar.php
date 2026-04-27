<?php
$loginButtonText = "Connexion🛠️";

if(isset($_SESSION["id_user"])){
    $loginButtonText = "Connecté✅";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="navbar">
        <nav>
            <div class="logo">
                <a href="index.php" title="Retour à l'accueil">PIXEL BLASTER</a>
            </div>
            <ul>
                <li><a href="GamePage.php" class="btn-jouer">JOUER AU JEU VIDEAL😈</a></li>
                <li><a href="market.php">Market🛒</a></li>
                <li><a href="scoreboards.php">Scores🏆</a></li>
                <li><a href="info.php">Infosℹ️</a></li>
                <li><a href="login.php" style="border: 1px solid #555;"><?php echo $loginButtonText;?></a></li>
            </ul>
        </nav>
    </div>
</body>
</html>