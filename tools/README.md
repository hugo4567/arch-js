Instructions rapide

Prérequis :
- Node.js installé sur le serveur
- Accès au dossier `out/public_html/tools`

Installation (dans `out/public_html/tools`) :

```bash
npm install
```

Exécution (depuis le même dossier) :

```bash
node generate_thumbnails.js
```

Ou via le fichier PHP `regenerate_thumbnails.php` (cliquez sur le bouton). Le script lira tous les fichiers `../levels/*.json` et écrira les images dans `../img/<levelId>.png`.

Notes :
- Ajustez les temps d'attente `waitForTimeout` si le jeu met plus de temps à charger.
- Puppeteer télécharge Chromium (~100MB+). Assurez-vous d'avoir suffisamment d'espace et les permissions.
