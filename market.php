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
        "name" => "Jm bigard tkt", 
        "price" => 250, 
        "desc" => "COMPLOTISTE", 
        "image" => "img/lvl3.png", 
        "file" => "test_jm_1777276726"
    ],
];

// Vérification de la connexion
if (!isset($_SESSION["id_user"])){
    header("Location: login.php");
    exit;
}

// 2. Récupération de l'argent EN DIRECT depuis la BDD
$db_money = get_pieces_user($conn, $_SESSION['id_user']);
$playerMoney = 0;

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
            
            // A. On récupère les infos de l'utilisateur (dont ses niveaux)
            $user = get_user_by_id($conn, $_SESSION['id_user']);
            
            // B. On extrait son tableau de niveaux existants
            $levels_data = is_string($user['levels']) ? json_decode($user['levels'], true) : $user['levels'];
            $current_levels = [];
            
            if (isset($levels_data['mes_niveaux']) && is_array($levels_data['mes_niveaux'])) {
                $current_levels = $levels_data['mes_niveaux'];
            }

            // C. On vérifie s'il possède déjà ce niveau
            if (in_array($item['file'], $current_levels)) {
                $message = "ERREUR : Tu possèdes déjà {$item['name']} !";
            } 
            // D. S'il ne l'a pas, on vérifie l'argent
            elseif ($playerMoney >= $item["price"]) {
                
                // Retire les pièces en Base de données
                $success = sub_pieces_user($conn, $_SESSION["id_user"], $item["price"]);
                
                if ($success !== false) {
                    
                    // --- AJOUT DU NIVEAU DANS LE JSON ---
                    $current_levels[] = $item['file'];
                    
                    // array_values(array_unique(...)) évite les doublons et garantit le format liste JSON [...]
                    $new_levels_json = json_encode(["mes_niveaux" => array_values(array_unique($current_levels))]);
                    
                    // Mise à jour dans la base de données (table users, colonne levels)
                    $stmt = $conn->prepare("UPDATE users SET levels = :levels WHERE id_user = :id_user");
                    $stmt->execute([
                        ':levels' => $new_levels_json,
                        ':id_user' => $_SESSION['id_user']
                    ]);
                    // ------------------------------------
                    
                    // Met à jour la variable locale pour l'affichage immédiat
                    $playerMoney -= $item["price"]; 
                    $message = "SUCCÈS : Tu as acheté {$item['name']} ! Il a été ajouté à tes niveaux.";
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