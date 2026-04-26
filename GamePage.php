<?php
session_start();
require_once __DIR__ . "/Backend/DB/db_connect.php";
require_once __DIR__ . "/navbar.php";

$user_levels = []; // On initialise un tableau vide par défaut
$is_logged_in = isset($_SESSION['id_user']); // Assure-toi que c'est bien le nom de ta variable de session

if ($is_logged_in) {
    // 1. On récupère le user et son tableau d'IDs de niveaux décodé
    require __DIR__ . "/Backend/CRUD/user.crud.php";
    $user = get_user_by_id($conn, $_SESSION['id_user']);

    if ($user && !empty($user['levels'])) {
        // 2. On sécurise les IDs et on en fait une chaîne "1,2,3"
        $ids_clean = array_map('intval', $user['levels']);
        $ids_string = implode(',', $ids_clean);
        
        // 3. On va chercher les infos des niveaux dans la table 'levels'
        // Attention: adapte "id_level" selon le vrai nom de ta clé primaire dans la table levels
        $sql = "SELECT * FROM levels WHERE id_level IN ($ids_string)";
        $result_levels = mysqli_query($conn, $sql);
        
        if ($result_levels) {
            while ($lvl = mysqli_fetch_assoc($result_levels)) {
                $user_levels[] = $lvl;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css"> </head>
    <meta charset="UTF-8">
    <title>Test Rapide du Jeu</title>
    <style>
        body { display: flex; background: #111; color: white; font-family: sans-serif; margin: 0; }
        #menu { width: 300px; padding: 20px; background: #222; }
        #game-container { flex-grow: 1; height: 100vh; }
        iframe { width: 100%; height: 100%; border: none; }
        button { background: #4CAF50; color: white; border: none; padding: 15px; width: 100%; cursor: pointer; font-size: 16px; font-weight: bold; border-radius: 5px; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>

    <div id="menu">
        <h2>Mes Niveaux</h2>
        
        <?php if ($is_logged_in): ?>
            <?php if (!empty($user_levels)): ?>
                <p>Choisis un niveau à lancer :</p>
                
                <?php foreach ($user_levels as $lvl): ?>
                    <button onclick="chargerEtLancerNiveau('<?php echo htmlspecialchars($lvl['chemin_fichier']); ?>')">
                        Jouer à "<?php echo htmlspecialchars($lvl['name']); ?>"
                    </button>
                    <br><br>
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

    <script>
        const gameIframe = document.getElementById('gameIframe');
        let jeuPret = false;

        window.addEventListener('message', (event) => {
            if (event.origin !== "https://ex-a01.github.io") return; 

            if (event.data && event.data.type === 'GAME_READY') {
                console.log("Le jeu est prét ! Tu peux cliquer sur le bouton.");
                jeuPret = true;
            }
        

            if (event.data && event.data.type === 'LEVEL_FINISHED') {
                const totalCoins = event.data.coins;
                console.log("Message reçu du jeu : Niveau terminé avec", totalCoins, "pièces !");
                
                // Ici tu peux faire ton affichage de victoire ou envoyer à la DB
                alert(`Bravo ! Tu as terminé le niveau en récoltant ${totalCoins} pièces !`);
                
                /* * Exemple pour la suite :
                 * fetch('sauvegarder_score.php', {
                 * method: 'POST',
                 * body: JSON.stringify({ pieces: totalCoins })
                 * });
                 */
            }
        });
        
        // 2. On envoie le niveau
        async function chargerEtLancerNiveau(cheminJsonServeur) {
            if (!jeuPret) {
                alert("Le WASM n'est pas encore ready. Regarde la console (F12) pour voir si le signal arrive !");
                return;
            }

            try {
                const response = await fetch(cheminJsonServeur); 
                if (!response.ok) throw new Error("Fichier introuvable.");
                const jsonText = await response.text();

                // ðŸ‘‡ DEUXIÃˆME LIGNE Ã€ VÃ‰RIFIER ðŸ‘‡
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