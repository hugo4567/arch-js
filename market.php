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
        "name" => "CHATEAU FINAL", 
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
    <style>
        /* On reprend ton style de login */
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body { 
            font-family: 'Press Start 2P', cursive; 
            background-color: #000;
            background-image: 
                linear-gradient(45deg, #111 25%, transparent 25%, transparent 75%, #111 75%, #111),
                linear-gradient(45deg, #111 25%, transparent 25%, transparent 75%, #111 75%, #111);
            background-size: 8px 8px;
            color: #fff; 
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px;
            image-rendering: pixelated;
        }

        .market { width: 100%; max-width: 600px; }

        h1 { font-size: 1.2rem; text-align: center; color: #e52521; margin-bottom: 30px; }

        .status-box {
            border: 4px solid #fff;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 8px 8px 0px rgba(255,255,255,0.1);
        }

        .item { 
            background: #000; 
            padding: 20px; 
            margin-bottom: 20px; 
            border: 4px solid #555; 
            box-shadow: 6px 6px 0px #333;
            position: relative;
        }
        
        .item:hover { border-color: #fff; }

        .item h3 { font-size: 0.8rem; margin-bottom: 10px; color: #fff; }
        .item p { font-size: 0.6rem; color: #aaa; margin-bottom: 15px; line-height: 1.4; }

        .buy-btn { 
            display: inline-block;
            background: #000; 
            padding: 10px 15px; 
            color: #fff; 
            text-decoration: none; 
            border: 4px solid #fff; 
            font-size: 0.7rem;
            transition: transform 0.1s;
        }

        .buy-btn:hover { background: #fff; color: #000; }
        .buy-btn:active { transform: translate(4px, 4px); }

        .msg { 
            margin-bottom: 30px; 
            padding: 15px; 
            border: 4px solid #e52521; 
            font-size: 0.7rem; 
            text-align: center;
            animation: blink 1s infinite;
        }

        .reset-btn {
            background: none;
            border: 4px solid #e52521;
            color: #e52521;
            padding: 10px;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.6rem;
            cursor: pointer;
            margin-top: 20px;
        }

        @keyframes blink {
            50% { opacity: 0.5; }
        }

        .item-img {
        width: 100%;
        height: 150px;
        background-color: #222; /* Fond en attendant l'image */
        margin-bottom: 15px;
        border: 2px solid #555;
        object-fit: cover; /* Garde les proportions */
        image-rendering: pixelated; /* Très important pour le style 8-bit */
    }

    .item-content {
        display: flex;
        flex-direction: column;
    }
    </style>
</head>
<body>

<div class="market">
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
            // Si on vient d'acheter cet item précisément
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