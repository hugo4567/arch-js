<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Niveaux JSON</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 300px;
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            transition: background-color 0.2s;
            text-align: left;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Sélectionnez un niveau</h1>

    <div class="button-container">
        <?php
        // Définition du chemin du dossier
        $dir = "./niveaux";

        // Vérifier si le dossier existe
        if (is_dir($dir)) {
            // Scanner le dossier et récupérer les fichiers
            $files = scandir($dir);

            $found = false;
            foreach ($files as $file) {
                // On vérifie que c'est bien un fichier .json et non les dossiers système . ou ..
                if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                    // Supprimer l'extension .json pour l'affichage sur le bouton
                    $buttonName = pathinfo($file, PATHINFO_FILENAME);
                    
                    // Génération du bouton HTML
                    // On peut ajouter un événement 'onclick' ou un formulaire si besoin
                    echo '<button type="button" onclick="loadLevel(\'' . htmlspecialchars($file) . '\')">';
                    echo htmlspecialchars($buttonName);
                    echo '</button>';
                    
                    $found = true;
                }
            }

            if (!$found) {
                echo "Aucun fichier JSON trouvé dans le dossier /niveaux.";
            }
        } else {
            echo "<p class='error'>Erreur : Le dossier '/niveaux' n'existe pas.</p>";
        }
        ?>
    </div>

    <script>
        // Fonction exemple pour traiter le clic sur un bouton
        function loadLevel(fileName) {
            alert("Vous avez cliqué sur le niveau : " + fileName);
            // Ici, vous pouvez rediriger ou charger le JSON via Fetch API
        }
    </script>

</body>
</html>