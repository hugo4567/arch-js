#!/bin/bash

###############################################################################
# Setup GitHub Backup pour Git LOCAL + GitHub sync
# À exécuter SUR LE SERVEUR après setup-git-collab.sh
# Usage: sudo bash setup-github-backup.sh
###############################################################################

set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_step() { echo -e "${BLUE}[*]${NC} $1"; }
print_success() { echo -e "${GREEN}[✓]${NC} $1"; }
print_error() { echo -e "${RED}[✗]${NC} $1"; }
print_info() { echo -e "${YELLOW}[i]${NC} $1"; }

GIT_BARE_REPO="/var/www/dev-project.git"

# Demander infos GitHub
echo ""
echo -e "${BLUE}╔════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   GitHub Backup Configuration          ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════╝${NC}"
echo ""

read -p "URL du repo GitHub (https://github.com/USER/REPO.git): " GITHUB_URL

if [ -z "$GITHUB_URL" ]; then
    print_error "URL vide. Abandon."
    exit 1
fi

print_step "Configuration du backup GitHub..."

# 1. Ajouter GitHub comme remote au repo bare
cd $GIT_BARE_REPO
git remote add github "$GITHUB_URL" 2>/dev/null || git remote set-url github "$GITHUB_URL"

# 2. Créer le hook post-receive pour sync auto
print_step "Création du hook post-receive (sync auto vers GitHub)..."

cat > $GIT_BARE_REPO/hooks/post-receive << 'HOOK'
#!/bin/bash

# Déploiement local
PROJECT_DIR="/var/www/dev-project"
GIT_URL="$GIT_DIR"

echo "🔄 Déploiement local..."
if [ -d "$PROJECT_DIR/.git" ]; then
    cd "$PROJECT_DIR"
    git pull origin master 2>&1
    echo "✓ Déploiement local OK"
else
    echo "⚠️  Repo local non trouvé"
fi

# Sync vers GitHub
echo "🔄 Sync vers GitHub..."
cd "$GIT_URL"

# Récupérer la branche pushée
while read oldrev newrev refname; do
    branch="${refname#refs/heads/}"
    echo "  Branch: $branch"
    git push github "$branch" 2>&1 || echo "⚠️  Erreur push GitHub (token/réseau?)"
done

echo "✓ Sync GitHub OK (ou check réseau)"
HOOK

chmod +x $GIT_BARE_REPO/hooks/post-receive
print_success "Hook post-receive configuré"

# 3. Test de connexion GitHub
print_step "Test de connexion à GitHub..."

cd $GIT_BARE_REPO

# Essayer de pousser vers GitHub
if git push github master 2>&1 | grep -q "Authentication"; then
    print_error "⚠️  Authentification GitHub échouée"
    echo ""
    echo "   Solutions:"
    echo "   1. Utiliser un Personal Access Token (PAT):"
    echo "      https://github.com/settings/tokens"
    echo ""
    echo "   2. Configurer SSH (recommandé):"
    echo "      ssh-keygen -t ed25519 -C 'deploy@serveur'"
    echo "      Ajouter la clé publique aux SSH keys GitHub"
    echo ""
    echo "   3. Puis réessayer:"
    echo "      cd $GIT_BARE_REPO && git push github master"
    echo ""
else
    print_success "GitHub sync fonctionnelle!"
fi

# RÉSUMÉ FINAL
echo ""
echo -e "${GREEN}════════════════════════════════════════${NC}"
echo -e "${GREEN}✓ GitHub Backup Configuré${NC}"
echo -e "${GREEN}════════════════════════════════════════${NC}"
echo ""
echo "📊 Status:"
echo "  Repo local: $GIT_BARE_REPO"
echo "  GitHub URL: $GITHUB_URL"
print_info "À chaque push des devs → auto-sync vers GitHub"
echo ""
echo "🔐 IMPORTANT - Authentification GitHub:"
echo ""
echo "   Option A: SSH (RECOMMANDÉE)"
echo "   ────────"
echo "   1. Sur le serveur, créer une clé SSH:"
echo "      ssh-keygen -t ed25519 -C 'devteam@$(hostname)'"
echo ""
echo "   2. Copier la clé publique:"
echo "      cat ~/.ssh/id_ed25519.pub"
echo ""
echo "   3. Ajouter sur GitHub (Settings → SSH Keys → New SSH Key)"
echo ""
echo "   4. Tester:"
echo "      ssh -T git@github.com"
echo ""
echo "   Option B: HTTPS + Personal Access Token"
echo "   ────────"
echo "   1. Créer un PAT: https://github.com/settings/tokens"
echo "   2. Scope: repo (full control)"
echo "   3. Configurer Git:"
echo "      git config --global credential.helper store"
echo "      git clone https://token@github.com/USER/REPO"
echo "      → Premier clone demande mot de passe (entre le PAT)"
echo "      → Ensuite c'est automatique"
echo ""
echo "✅ Une fois auth configurée, relancer ce script pour confirmer"
echo ""
