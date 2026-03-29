#!/bin/bash

###############################################################################
# Configuration Code-server optimisée pour PHP/JS/HTML dev
# Usage: bash setup-code-server-config.sh
###############################################################################

# Dossier config de code-server
CONFIG_DIR="$HOME/.config/code-server"
SETTINGS_FILE="$CONFIG_DIR/settings.json"

mkdir -p $CONFIG_DIR

echo "⚙️  Configuration Code-server..."

# 1. Config de base
cat > $CONFIG_DIR/coder.json << 'EOF'
{
  "password": "changeme",
  "auth": "password"
}
EOF

# 2. Settings.json (recommandations dev)
cat > $SETTINGS_FILE << 'EOF'
{
  "[html]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode",
    "editor.formatOnSave": true,
    "editor.tabSize": 2
  },
  "[css]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode",
    "editor.formatOnSave": true,
    "editor.tabSize": 2
  },
  "[javascript]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode",
    "editor.formatOnSave": true,
    "editor.tabSize": 2
  },
  "[php]": {
    "editor.defaultFormatter": "DEVSENSE.phptools-vscode",
    "editor.formatOnSave": true,
    "editor.tabSize": 4
  },
  "[json]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode",
    "editor.formatOnSave": true
  },
  "editor.fontSize": 14,
  "editor.fontFamily": "Fira Code, monospace",
  "editor.theme": "One Dark Pro",
  "editor.wordWrap": "on",
  "editor.trimAutoWhitespace": true,
  "files.autoSave": "afterDelay",
  "files.autoSaveDelay": 1000,
  "extensions.recommendations": [
    "esbenp.prettier-vscode",
    "ms-vscode.vscode-js-profile-flame",
    "dbaeumer.vscode-eslint",
    "ms-azuretools.vscode-docker",
    "eamodio.gitlens",
    "GitHub.github-vscode-theme",
    "ritwickdey.liveserver"
  ]
}
EOF

echo "✓ Settings.json créé"

# 3. Extensions recommandées via CLI
echo "Installation des extensions..."

# Code-server n'expose pas toujours les extensions, on peut les installer manuellement
# Ou utiliser directement: code-server --install-extension <extension-id>

extensions=(
  "esbenp.prettier-vscode"          # Prettier (formatage JS/HTML)
  "dbaeumer.vscode-eslint"          # ESLint
  "eamodio.gitlens"                 # GitLens
  "ms-azuretools.vscode-docker"     # Docker
  "github.github-vscode-theme"      # GitHub theme
  "ritwickdey.liveserver"           # Live Server (preview)
)

for ext in "${extensions[@]}"; do
  echo "  → $ext"
done

echo ""
echo "⚙️  Configuration optimisée!"
echo ""
echo "📍 Pour les extensions: Accédez à code-server et installez via Extensions"
echo "   (cherchez les noms listés ci-dessus)"
echo ""
echo "💡 TIPS POUR VOS 4 DEVS:"
echo "  • Utilisez GitLens pour voir qui a modifié quoi"
echo "  • Live Server pour preview HTML en temps réel"
echo "  • Prettier pour formatage auto (Shift+Alt+F)"
echo "  • Git est intégré dans Code-server directement"
echo ""
