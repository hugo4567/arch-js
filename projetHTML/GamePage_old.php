<?php
session_start();
require_once __DIR__ . "/Backend/DB/db_connect.php";
require_once __DIR__ . "/Backend/CRUD/user.crud.php";
require_once __DIR__ . "/Backend/CRUD/levels.crud.php";

$user_levels = []; 
$is_logged_in = isset($_SESSION['id_user']);

if ($is_logged_in) {
    $user = get_user_by_id($conn, $_SESSION['id_user']);

    if ($user && isset($user['levels']['mes_niveaux']) && is_array($user['levels']['mes_niveaux'])) {
        $user_levels = $user['levels']['mes_niveaux']; 
    }
} else {
    header('Location: login.php');
    exit; 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Rapide du Jeu</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        display: flex;
        flex-direction: column;
        background: #111;
        color: white;
        font-family: sans-serif;
        margin: 0;
        height: 100vh;
        overflow: hidden;
    }
    #main-content {
        display: flex;
        flex: 1;
        overflow: hidden;
    }
    #menu { width: 300px; padding: 20px; background: #222; }
    #game-container { flex-grow: 1; }
    iframe { width: 100%; height: 100%; border: none; }
    button { 
        /* Couleurs & Fond */
        background: #31005f; 
        color: #FFFFFF !important; /* <--- CHANGE CETTE LIGNE PAR #FFFFFF */
        border: 1px solid #5a189a;
        
        padding: 15px; 
        width: 100%; 
        border-radius: 6px; 
        
        font-size: 16px; 
        font-weight: bold; 
        text-align: center;
        
        cursor: pointer; 
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s ease-in-out;
        transition: transform 0.3s;
    }

    button:hover { 
        background: #3c096c;
        border-color: #c77dff;
        box-shadow: 0 0 10px rgba(199, 125, 255, 0.2);
        color: #ffffff;
        transform: rotate(360deg) translateX(20px) skew(30deg, 20deg);
        
    }


    button:active { 
        background: #7b2cbf; 
        border-color: #e0aaff;
        color: white;
        box-shadow: 0 0 15px rgba(123, 44, 191, 0.4);
        transform: translateY(1px);
        transform: translateY(1px);
    }
    
</style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div id="main-content">
        <div id="menu">
            <h2>Mes Niveaux</h2>
            
            <?php if ($is_logged_in): ?>
                <?php if (!empty($user_levels)): ?>
                    <p>Choisis un niveau à lancer :</p>
                    
                    <?php foreach ($user_levels as $filename): ?>
                        <div class="text">
                            <?php
                                $chemin_complet = "/~grp1/levels/" . htmlspecialchars($filename) . ".json";
                                $nom_propre = preg_replace('/_[0-9]+$/', '', $filename);
                                $_SESSION['nom_propre'] = $nom_propre;
                                $ret = get_all_levels_by_name($conn, $nom_propre);
                                $_SESSION['idlevel'] = $ret[0]['id'];
                                ?>
                        </div>
                        <button onclick="chargerEtLancerNiveau('<?php echo $chemin_complet; ?>')">
                            Lancer "<?php echo htmlspecialchars($nom_propre); ?>"
                        </button>
                        <br>
                    <?php endforeach; ?>
                    
                <?php else: ?>
                    <p>Tu ne possèdes aucun niveau dans ton inventaire.</p>
                <?php endif; ?>
                
            <?php else: ?>
                <p>Veuillez vous connecter pour voir vos niveaux.</p>
            <?php endif; ?>
        </div>

        <div id="game-container">
        <iframe id="gameIframe" src="https://ex-a01.github.io/ARCH-JS/"></iframe>
        </div>
    </div>
    <script>
        const gameIframe = document.getElementById('gameIframe');
        let jeuPret = false;

        window.addEventListener('message', (event) => {
            if (event.origin !== "https://ex-a01.github.io") return; 

            if (event.data && event.data.type === 'GAME_READY') {
                console.log("Le jeu est prêt ! Tu peux cliquer sur le bouton.");
                jeuPret = true;
            }

            if (event.data && event.data.type === 'LEVEL_FINISHED') {
                const totalCoins = event.data.coins;
                console.log("Message reçu du jeu : Niveau terminé avec", totalCoins, "pièces !");
                alert(`Bravo ! Tu as terminé le niveau en récoltant ${totalCoins} pièces !`);

                fetch("Backend/Score/sauvegarder_score.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'coins=' + encodeURIComponent(totalCoins)
                    //p:'levelid=' + get_level_by_name($nom_propre)
                })
                .then(response => {
                    // verif si json
                    const contentType = response.headers.get("content-type");
                    
                    if (response.ok && contentType && contentType.includes("application/json")) {
                        return response.json();
                    }
                    
                    // si pas json
                    return response.text().then(text => {
                        throw new Error(`Réponse non-JSON reçue : ${text}`);
                    });
                })
                .then(data => {
                    // si json
                    console.log("Score sauvegardé avec succès :", data);
                })
                .catch(error => {

                    console.error("Détails de l'erreur :");
                    console.error(error.message);
                    console.warn("Vérifie ton fichier PHP : chemin correct ? Erreurs PHP affichées dans le texte ?");
                });
            }
        });
        
        async function chargerEtLancerNiveau(cheminJsonServeur) {
            if (!jeuPret) {
                alert("Le jeu n'est pas encore prêt. Patiente quelques secondes.");
                return;
            }

            try {
                const response = await fetch(cheminJsonServeur); 
                if (!response.ok) throw new Error("Fichier introuvable.");
                const jsonText = await response.text();

                gameIframe.contentWindow.postMessage({
                    type: 'LOAD_LEVEL',
                    data: jsonText
                }, "https://ex-a01.github.io"); 

            } catch (error) {
                console.error("Erreur :", error);
            }
        }
    </script>
</body>
</html>