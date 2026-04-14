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

    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

function generateRandomText() {
    $words = ['apple', 'banana', 'cherry', 'dragon', 'elephant', 'forest', 'galaxy', 'horizon', 'island', 'jungle'];
    $randomWords = array_rand($words, min(3, rand(3, 5)));
    $text = [];
    foreach ((array)$randomWords as $index) {
        $text[] = $words[$index];
    }
    return implode(' ', $text);
}

function generateRandomName() {
    $firstNames = ['Alex', 'Jordan', 'Sam', 'Casey', 'Morgan', 'Taylor'];
    $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia'];
    return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
}

// Créer le répertoire s'il n'existe pas
if (!is_dir('./levels')) {
    mkdir('./levels', 0755, true);
}

// Générer les données
$data = [
    'name' => generateRandomName(),
    'cells' => [
        generateRandomText(),
        generateRandomText(),
        generateRandomText()
    ]
];

// Créer le fichier JSON
$filename = './levels/' . str_replace(' ', '_', $data['name']) . '_' . time() . '.json';
$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

// Sauvegarder le fichier
if (file_put_contents($filename, $json)) {
    echo json_encode([
        'success' => true,
        'message' => 'Fichier créé avec succès',
        'filename' => basename($filename),
        'data' => $data
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de la création du fichier'
    ]);
}}
?>
<form method="POST">
        <button type="submit">Générer JSON</button>
    </form>
</body>
</html>