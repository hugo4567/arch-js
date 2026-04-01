echo("oui")
oui
<?php
// --- CONFIG / DATA ---
$items = [
    ["id" => 1, "name" => "Épée en fer", "price" => 150, "desc" => "Une épée simple mais fiable."],
    ["id" => 2, "name" => "Potion de soin", "price" => 50, "desc" => "Rend 25 HP."],
    ["id" => 3, "name" => "Arc de chêne", "price" => 200, "desc" => "Arc léger et précis."],
];

// Exemple de monnaie du joueur (à remplacer par ta DB)
$playerMoney = 300;

// Gestion achat
$message = "";
if (isset($_GET['buy'])) {
    $id = intval($_GET['buy']);
    foreach ($items as $item) {
        if ($item["id"] === $id) {
            if ($playerMoney >= $item["price"]) {
                $playerMoney -= $item["price"];
                $message = "Tu as acheté : <b>{$item['name']}</b> !";
            } else {
                $message = "Tu n'as pas assez d'argent.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Marché du jeu</title>
    <style>
        body { font-family: Arial; background: #1e1e1e; color: #fff; }
        .market { width: 600px; margin: 40px auto; }
        .item { background: #2c2c2c; padding: 15px; margin-bottom: 10px; border-radius: 6px; }
        .item h3 { margin: 0; }
        .buy-btn { background: #4caf50; padding: 8px 12px; color: white; text-decoration: none; border-radius: 4px; }
        .buy-btn:hover { background: #45a049; }
        .msg { margin-bottom: 20px; padding: 10px; background: #333; border-left: 4px solid #4caf50; }
    </style>
</head>
<body>

<div class="market">
    <h1>🛒 Marché</h1>
    <p>Argent du joueur : <b><?php echo $playerMoney; ?> 💰</b></p>

    <?php if ($message): ?>
        <div class="msg"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php foreach ($items as $item): ?>
        <div class="item">
            <h3><?php echo $item["name"]; ?> — <?php echo $item["price"]; ?> 💰</h3>
            <p><?php echo $item["desc"]; ?></p>
            <a class="buy-btn" href="?buy=<?php echo $item['id']; ?>">Acheter</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
