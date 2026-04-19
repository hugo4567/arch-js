<?php
session_start();
require_once __DIR__ . "/Backend/DB/db_connect.php";

/*$user = get_user_by_id($conn, $_SESSION['id_user']);

if (!empty($user['levels'])) {
    // Transforme le tableau [1, 4, 7] en chaîne "1,4,7" pour la requête SQL
    $ids_string = implode(',', $user['levels']); 
    
    // On va chercher toutes les infos des niveaux que le joueur possède
    $sql = "SELECT * FROM levels WHERE id IN ($ids_string)";
    $result_levels = mysqli_query($conn, $sql);
    
    while ($lvl = mysqli_fetch_assoc($result_levels)) {
        echo "<button>Jouer à " . $lvl['name'] . "</button>";
    }
} else {
    echo "Tu ne possèdes aucun niveau.";
}*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
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
        <h2>Menu de Test</h2>
        <p>Le bouton envoie le fichier <b>Test.json</b> à l'Iframe.</p>
        
        <button onclick="chargerEtLancerNiveau('/~grp1/Levels/Test_1776618458.json')">
            🎮 Lancer "Test.json"
        </button>
    </div>

    <div id="game-container">
       <iframe id="gameIframe" src="https://ex-a01.github.io/ARCH-JS/"></iframe>
    </div>

    <script>
        const gameIframe = document.getElementById('gameIframe');
        let jeuPret = false;

        // 1. On écoute le jeu
        window.addEventListener('message', (event) => {
            // 👇 LIGNE À VÉRIFIER ABSOLUMENT 👇
            if (event.origin !== "https://ex-a01.github.io") return; 

            if (event.data && event.data.type === 'GAME_READY') {
                console.log("✅ Le jeu est prêt ! Tu peux cliquer sur le bouton.");
                jeuPret = true;
            }
        });

        // 2. On envoie le niveau
        async function chargerEtLancerNiveau(cheminJsonServeur) {
            if (!jeuPret) {
                alert("Le WASM n'est pas encore prêt. Regarde la console (F12) pour voir si le signal arrive !");
                return;
            }

            try {
                const response = await fetch(cheminJsonServeur); 
                if (!response.ok) throw new Error("Fichier introuvable.");
                const jsonText = await response.text();

                // 👇 DEUXIÈME LIGNE À VÉRIFIER 👇
                gameIframe.contentWindow.postMessage({
                    type: 'LOAD_LEVEL',
                    data: jsonText
                }, "https://ex-a01.github.io"); 

            } catch (error) {
                console.error("❌ Erreur :", error);
            }
        }
    </script>
</body>
</html>