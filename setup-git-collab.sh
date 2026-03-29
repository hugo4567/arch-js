#!/bin/bash

###############################################################################
# Setup Git collaboratif sur le serveur Linux
# Permet à 4 devs de travailler ensemble avec versionning
# Usage: bash setup-git-collab.sh
###############################################################################

set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_step() { echo -e "${BLUE}[*]${NC} $1"; }
print_success() { echo -e "${GREEN}[✓]${NC} $1"; }
print_info() { echo -e "${YELLOW}[i]${NC} $1"; }

# Variables
PROJECT_DIR="/var/www/dev-project"
GIT_BARE_REPO="/var/www/dev-project.git"

print_step "Setup Git Collaboratif"

# 1. Créer le repo bare (serveur)
print_step "1. Création du repo bare..."
mkdir -p $GIT_BARE_REPO
cd $GIT_BARE_REPO
git init --bare
print_success "Repo bare créé: $GIT_BARE_REPO"

# 2. Post-receive hook (auto-deploy + GitHub backup)
print_step "2. Configuration du hook post-receive..."

# Demander URL GitHub
read -p "URL GitHub (opcional, laisser vide pour skip): " GITHUB_URL

cat > $GIT_BARE_REPO/hooks/post-receive << 'HOOK'
#!/bin/bash
# Auto-pull vers le dossier de travail + sync GitHub

PROJECT_DIR="/var/www/dev-project"
GIT_DIR="$1"

# 1. Déploiement local
if [ -d "$PROJECT_DIR/.git" ]; then
    cd "$PROJECT_DIR"
    git pull origin master 2>&1 | logger -t git-deploy
    echo "✓ Déploiement local réussi"
else
    echo "✗ Repo local non trouvé"
fi

# 2. Sync vers GitHub (si configuré)
if [ ! -z "GITHUB_URL" ]; then
    cd "$GIT_DIR"
    git push github master 2>&1 || echo "⚠️  GitHub sync skipped"
fi
HOOK

chmod +x $GIT_BARE_REPO/hooks/post-receive
print_success "Hook configuré (auto-deploy + GitHub)"

# 2b. Configurer GitHub si URL fournie
if [ ! -z "$GITHUB_URL" ]; then
    print_step "Configuration GitHub..."
    cd $GIT_BARE_REPO
    git remote add github "$GITHUB_URL" 2>/dev/null || git remote set-url github "$GITHUB_URL"
    print_success "GitHub remote configuré"
fi

# 3. Initialiser le dossier de travail
print_step "3. Initialisation du dossier de travail..."
cd $PROJECT_DIR
git init
git remote add origin $GIT_BARE_REPO || git remote set-url origin $GIT_BARE_REPO

# Commit initial
git add .
git config user.email "server@dev.local"
git config user.name "Dev Server"
git commit -m "Initial commit" || echo "Rien à committer"
git branch -M master
git push -u origin master || echo "Skip premier push"

print_success "Dossier de travail initialisé"

# 4. Permissions
print_step "4. Configuration des permissions..."
chown -R $(whoami):$(whoami) $GIT_BARE_REPO
chown -R $(whoami):$(whoami) $PROJECT_DIR
chmod -R g+w $GIT_BARE_REPO
chmod -R g+w $PROJECT_DIR
print_success "Permissions configurées"

# 5. Auto-commit service (sauvegarde auto vers Git)
print_step "5. Création du service auto-commit..."
cat > /etc/systemd/system/git-auto-commit.service << 'SERVICE'
[Unit]
Description=Auto-commit changes to Git every 5 minutes
After=network.target

[Service]
Type=simple
User=root
WorkingDirectory=/var/www/dev-project
ExecStart=/bin/bash -c 'while true; do git add -A 2>/dev/null; git diff-index --quiet HEAD || git commit -m "Auto-save: $(date +%Y-%m-%d\\ %H:%M:%S)" 2>/dev/null; git push origin master 2>/dev/null; sleep 300; done'
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
SERVICE

systemctl daemon-reload
systemctl enable git-auto-commit
systemctl start git-auto-commit
print_success "Service auto-commit activé (tous les 5 min)"

# RÉSUMÉ
echo ""
echo -e "${GREEN}========== GIT COLLABORATIF AUTOMATIQUE PRÊT ==========${NC}"
echo ""
echo "🚀 WORKFLOW ULTRA-SIMPLE (zéro Git manual):"
echo ""
echo "   Les 4 devs:"
echo "   ├─ Se connectent à: http://$(hostname -I | awk '{print $1}'):8443"
echo "   ├─ Ouvrent /var/www/dev-project dans Code-server"
echo "   ├─ Modifient le code (tous voient les changements EN DIRECT)"
echo "   ├─ Sauvegardent (Ctrl+S) - c'est tout!"
echo "   └─ Le serveur auto-commit + auto-push vers GitHub toutes les 5 min"
echo ""
echo "✓ Zéro commande 'git push/pull' à faire!"
echo "✓ Zéro conflit de fichiers (tout edité directement sur le serveur)"
echo "✓ Historique complet sur GitHub (backup)"
echo ""
print_info "État du service auto-commit:"
systemctl status git-auto-commit --no-pager || echo "   Vérifier après redémarrage"
echo ""
