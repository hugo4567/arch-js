<?php
session_start();

// 1. Inclusions au tout début
require_once __DIR__ . "/Backend/DB/db_connect.php";
require_once __DIR__ . "/Backend/CRUD/user.crud.php";

// --- CONFIG / DATA ---
$items = [
    [
        "id" => 1, 
        "name" => "HUH level", 
        "price" => 50, 
        "desc" => "Le game engine se demande", 
        "image" => "img/lvl1.png", 
        "file" => "HUH_1777219013"
    ],
    [
        "id" => 2, 
        "name" => "Space level", 
        "price" => 100, 
        "desc" => "La gravité dit faaahhhh", 
        "image" => "img/lvl2.png", 
        "file" => "LeFaahhDeLespace_1777218686"
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

// Vérification de la connexion
if (!isset($_SESSION["id_user"])){
    header("Location: login.php");
    exit;
}

// 2. Récupération de l'argent EN DIRECT depuis la BDD (plus de $_SESSION["money"])
$db_money = get_pieces_user($conn, $_SESSION['id_user']);
$playerMoney = 0;

// Gestion sécurisée du retour de la fonction (au cas où elle renvoie un tableau)
if (is_array($db_money)) {
    $playerMoney = isset($db_money['coins']) ? (int)$db_money['coins'] : (int)reset($db_money);
} else {
    $playerMoney = (int)$db_money;
}

// 3. Gestion de l'achat
$message = "";
if (isset($_GET['buy'])) {
    $id = intval($_GET['buy']);
    
    foreach ($items as $item) {
        if ($item["id"] === $id) {
            // On compare directement avec l'argent récupéré en base de données
            if ($playerMoney >= $item["price"]) {
                
                // Retire les pièces en Base de données
                $success = sub_pieces_user($conn, $_SESSION["id_user"], $item["price"]);
                
                if ($success !== false) {
                    // Met à jour la variable locale pour l'affichage immédiat
                    $playerMoney -= $item["price"]; 
                    $message = "SUCCÈS : Tu as acheté {$item['name']} !";
                } else {
                    $message = "ERREUR : Impossible de finaliser l'achat côté serveur.";
                }

            } else {
                $message = "ERREUR : Pas assez d'argent !";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>8-BIT MARKET</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="page-market"> 
    <?php include 'navbar.php'; ?>
    <video autoplay muted loop playsinline class="bg-video">
        <source src="img/background.mp4" type="video/mp4">
    </video>
    <div class="market">
        <h1>🛒 MARCHÉ NOIR</h1>

        <!-- Affichage du message de succès ou d'erreur -->
        <?php if (!empty($message)): ?>
            <div class="message-box" style="background: rgba(0,0,0,0.8); padding: 10px; margin-bottom: 20px; border: 2px solid #fff; text-align: center;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="or">
            <div class="status-box">
                OR : <?php echo $playerMoney; ?> G
            </div>
        </div>

        <div class="page-market">
            <div class="market-grid">
                
                <?php foreach ($items as $item): ?>
                    <div class="item-card">
                        <h3>
                            <?php echo htmlspecialchars($item['name']); ?>
                        </h3>
                        <p>
                            <?php echo $item['price']; ?>G - <?php echo htmlspecialchars($item['desc']); ?>
                        </p>

                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="preview">
                        
                        <a href="?buy=<?php echo $item['id']; ?>" class="buy-btn">ACHETER (<?php echo $item['price']; ?>G)</a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
    <footer>
        <p>&copy; 2026 ARCH JS Team - Tout droit réservé</p>
    </footer>
</body>
</html>