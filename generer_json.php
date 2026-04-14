<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur JSON</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        button {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #764ba2;
        }
        pre {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            text-align: left;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Générateur JSON Aléatoire</h1>
        <button onclick="generateAndDownload()">Générer & Télécharger JSON</button>
        <div id="preview"></div>
    </div>

    <script>
        function generateRandomText() {
            const words = ['apple', 'banana', 'cherry', 'dragon', 'elephant', 'forest', 'galaxy', 'horizon', 'island', 'jungle'];
            return Array.from({length: Math.floor(Math.random() * 5) + 3}, 
                () => words[Math.floor(Math.random() * words.length)]).join(' ');
        }

        function generateRandomName() {
            const firstNames = ['Alex', 'Jordan', 'Sam', 'Casey', 'Morgan', 'Taylor'];
            const lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia'];
            return `${firstNames[Math.floor(Math.random() * firstNames.length)]} ${lastNames[Math.floor(Math.random() * lastNames.length)]}`;
        }

        function generateJSON() {
            return {
                name: generateRandomName(),
                cells: [
                    generateRandomText(),
                    generateRandomText(),
                    generateRandomText()
                ]
            };
        }

        function generateAndDownload() {
            const data = generateJSON();
            const json = JSON.stringify(data, null, 2);
            
            // Afficher l'aperçu
            document.getElementById('preview').innerHTML = `<pre>${json}</pre>`;
            
            // Télécharger le fichier
            const blob = new Blob([json], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${data.name.replace(/\s+/g, '_')}_${Date.now()}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>