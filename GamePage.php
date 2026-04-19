<?php
session_start();
require_once __DIR__ . "/Backend/DB/db_connect.php";

$user = get_user_by_id($conn, $_SESSION['id_user']);

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
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jouer - Goozy</title>
    <style>
        /* Ton style... */
        body { display: flex; background: #111; color: white; }
        #menu-niveaux { width: 300px; padding: 20px; background: #222; }
        #game-container { flex-grow: 1; }
        iframe { width: 100%; height: 100vh; border: none; }
        button { display: block; width: 100%; margin-bottom: 10px; padding: 10px; cursor: pointer; }
    </style>
</head>
<body>

    <div id="menu-niveaux">
        <h2>Tes Niveaux</h2>
        
        <?php if(empty($levels_disponibles)): ?>
            <p>Tu n'as aucun niveau pour le moment.</p>
        <?php else: ?>
            <?php foreach($levels_disponibles as $lvl): ?>
                <button onclick="chargerEtLancerNiveau('<?= htmlspecialchars($lvl['chemin_fichier']) ?>')">
                    🎮 Jouer : <?= htmlspecialchars($lvl['nom_niveau']) ?>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div id="game-container">
        <iframe id="gameIframe" src="https://ex-a01.github.io/ARCH-JS/"></iframe>
    </div>

    <script>
        const gameIframe = document.getElementById('gameIframe');
        let jeuPret = false;

        // 1. On attend que le jeu nous dise qu'il a fini de booter
        window.addEventListener('message', (event) => {
            if (event.origin !== "https://ex-a01.github.io") return;

            if (event.data && event.data.type === 'GAME_READY') {
                console.log("Le jeu est chargé et prêt à recevoir des niveaux !");
                jeuPret = true;
            }
        });

        // 2. Fonction appelée quand on clique sur un bouton de niveau
        async function chargerEtLancerNiveau(cheminJsonServeur) {
            if (!jeuPret) {
                alert("Le jeu est encore en cours de chargement, patiente une seconde !");
                return;
            }

            try {
                // A. Le JS de ton serveur va lire le fichier .json stocké dans ton dossier /Levels
                const response = await fetch('/' + cheminJsonServeur); 
                if (!response.ok) throw new Error("Impossible de lire le fichier JSON.");
                
                // B. On extrait le texte
                const jsonText = await response.text();

                // C. On envoie la data pure à l'Iframe GitHub Pages
                gameIframe.contentWindow.postMessage({
                    type: 'LOAD_LEVEL',
                    data: jsonText
                }, "https://ex-a01.github.io");

            } catch (error) {
                console.error("Erreur de chargement :", error);
                alert("Erreur lors du chargement du niveau.");
            }
        }
    </script>
</body>
</html>