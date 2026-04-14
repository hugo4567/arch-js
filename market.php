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
<body class="page-market"> <div class="market">
    <h1>🛒 MARCHÉ NOIR</h1>

    <div class="status-box">
        OR : <?php echo $playerMoney; ?> G
    </div>

    <?php if ($message): ?>
        <div class="msg"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php foreach ($items as $item): ?>
    <div class="item">
        <img src="<?php echo $item['image']; ?>" alt="Preview" class="item-img">
        
        <div class="item-content">
            <h3><?php echo $item["name"]; ?> — <?php echo $item["price"]; ?>G</h3>
            <p><?php echo $item["desc"]; ?></p>
            
            <?php 
            if (isset($_GET['buy']) && intval($_GET['buy']) == $item['id'] && strpos($message, 'SUCCÈS') !== false): 
            ?>
                <a class="buy-btn" href="<?php echo $item['file']; ?>" download style="border-color: #4caf50; color: #4caf50;">
                    CLIQUE ICI POUR LE ZIP
                </a>
            <?php else: ?>
                <a class="buy-btn" href="?buy=<?php echo $item['id']; ?>">
                    ACHETER (<?php echo $item['price']; ?>G)
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if ($playerMoney < 50): ?>
        <form method="POST" style="text-align:center;">
            <button type="submit" name="reset_money" class="reset-btn">
                PLUS D'OR ? [RESET 300G]
            </button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>