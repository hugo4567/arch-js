<?php
session_start();

// --- CONFIG / DATA ---
$items = [
    [
        "id" => 1, 
        "name" => "MONDE 1-1", 
        "price" => 50, 
        "desc" => "La plaine verdoyante.", 
        "image" => "img/lvl1.png", 
        "file" => "downloads/level1.zip"
    ],
    [
        "id" => 2, 
        "name" => "MONDE 1-2", 
        "price" => 100, 
        "desc" => "Les mines de charbon.", 
        "image" => "img/lvl2.png", 
        "file" => "downloads/level2.zip"
    ],
    [
        "id" => 3, 
        "name" => "MONDE 1-3", 
        "price" => 250, 
        "desc" => "Le trône du boss.", 
        "image" => "img/lvl3.png", 
        "file" => "downloads/level3.zip"
    ],
];

// Initialisation de l'argent
if (!isset($_SESSION["money"])) {
    $_SESSION["money"] = 300;
}

// GESTION DU RESET (Si on appuie sur le bouton de secours)
if (isset($_POST['reset_money'])) {
    $_SESSION["money"] = 300;
    header("Location: " . $_SERVER['PHP_SELF']); // Clean l'URL
    exit();
}

// Gestion achat
$message = "";
if (isset($_GET['buy'])) {
    $id = intval($_GET['buy']);
    foreach ($items as $item) {
        if ($item["id"] === $id) {
            if ($_SESSION["money"] >= $item["price"]) {
                $_SESSION["money"] -= $item["price"];
                $message = "SUCCÈS : Tu as acheté {$item['name']} !";
            } else {
                $message = "ERREUR : Pas assez d'argent !";
            }
        }
    }
}

$playerMoney = $_SESSION["money"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>8-BIT MARKET</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="page-market"> 
    <div class="market">
    <h1>🛒 MARCHÉ NOIR</h1>

    <div class="status-box">
        OR : <?php echo $playerMoney; ?> G
    </div>
    <div class="page-market">
    <div class="market-grid">
        
        <div class="item-card">
            <h3>MONDE 1-1</h3>
            <p>50G - La plaine verdoyante.</p>
            <img src="ton-image-mario.png" alt="preview">
            <a href="#" class="buy-btn">ACHETER (50G)</a>
        </div>

        <div class="item-card">
            <h3>MONDE 1-2</h3>
            <p>100G - Les mines.</p>
            <img src="ton-image-mario2.png" alt="preview">
            <a href="#" class="buy-btn">ACHETER (100G)</a>
        </div>

    </div>
</div>

</div>

</body>
</html>