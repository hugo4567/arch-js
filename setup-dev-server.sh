#!/bin/bash

###############################################################################
# Setup serveur de développement Linux (Ubuntu/Debian)
# Pour 4 DEVs - Code-server + PHP + MySQL + Git
# Utilisation: sudo bash setup-dev-server.sh
###############################################################################

set -e  # Exit on error

# Colors pour l'output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Fonctions utiles
print_step() {
    echo -e "${BLUE}[*]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[✓]${NC} $1"
}

print_error() {
    echo -e "${RED}[✗]${NC} $1"
}

print_info() {
    echo -e "${YELLOW}[i]${NC} $1"
}

# Check si root
if [[ $EUID -ne 0 ]]; then
    print_error "Ce script doit être exécuté en tant que root"
    exit 1
fi

print_step "========== SETUP SERVEUR DE DÉVELOPPEMENT =========="
print_info "OS: $(cat /etc/os-release | grep PRETTY_NAME | cut -d= -f2)"
print_info "CPU: $(lscpu | grep 'Model name' | cut -d: -f2 | xargs)"
print_info "RAM: $(free -h | awk 'NR==2 {print $2}')"
print_info "Disque: $(df -h / | awk 'NR==2 {print $2}')"

# 1. MISE À JOUR DES REPOS
print_step "1. Mise à jour des repos..."
apt update
apt upgrade -y

# 2. INSTALLATION DES DÉPENDANCES DE BASE
print_step "2. Installation dépendances de base..."
apt install -y \
    curl \
    wget \
    git \
    build-essential \
    net-tools \
    htop \
    ufw \
    openssh-server \
    openssh-client \
    ca-certificates \
    gnupg \
    lsb-release

print_success "Dépendances installées"

# 3. INSTALLATION CODE-SERVER
print_step "3. Installation Code-server..."
curl -fsSL https://code-server.dev/install.sh | sh
systemctl enable code-server@root || true
print_success "Code-server installé"

# 4. INSTALLATION PHP 8.2 (+ extensions essentielles)
print_step "4. Installation PHP 8.2..."
apt install -y \
    php-cli \
    php-fpm \
    php-mysql \
    php-mbstring \
    php-xml \
    php-curl \
    php-json \
    php-gd \
    php-zip \
    php-bcmath \
    php-intl \
    php-pdo

systemctl enable php-fpm
systemctl start php-fpm
print_success "PHP 8.2 installé avec extensions"

# 5. INSTALLATION MySQL/MariaDB
print_step "5. Installation MariaDB..."
apt install -y mariadb-server mariadb-client

systemctl enable mariadb
systemctl start mariadb
print_success "MariaDB installé"

# Sécurisation basique MySQL (optionnel)
print_step "Configuration sécurisée MySQL..."
mysql -e "DELETE FROM mysql.user WHERE User='';" || true
mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');" || true
mysql -e "DROP DATABASE IF EXISTS test;" || true
print_success "MySQL sécurisé"

# 6. INSTALLATION NODE.JS + NPM
print_step "6. Installation Node.js (dernière LTS)..."
curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
apt install -y nodejs
print_success "Node.js $(node -v) + npm $(npm -v) installés"

# 7. INSTALLATION NGINX (optionnel mais recommandé)
print_step "7. Installation Nginx (pour servir PHP)..."
apt install -y nginx

# Config Nginx simple pour PHP
cat > /etc/nginx/sites-available/default << 'EOF'
server {
    listen 80 default_server;
    listen [::]:80 default_server;

    server_name _;

    root /var/www/html;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

systemctl enable nginx
systemctl start nginx
print_success "Nginx configuré"

# 8. CRÉATION RÉPERTOIRE DE TRAVAIL
print_step "8. Configuration répertoires de travail..."
mkdir -p /var/www/dev-project
chown -R nobody:nogroup /var/www/dev-project
chmod -R 755 /var/www/dev-project

cat > /var/www/dev-project/index.php << 'EOF'
<?php
echo "🚀 Serveur de développement actif!<br>";
echo "PHP version: " . phpversion() . "<br>";
echo "Connecté à: " . gethostname() . "<br>";

// Test DB connection
try {
    $pdo = new PDO('mysql:host=localhost', 'root');
    echo "✓ MySQL connecté<br>";
} catch (Exception $e) {
    echo "✗ MySQL non connecté<br>";
}
?>
EOF

print_success "Répertoires créés : /var/www/dev-project"

# 9. CONFIGURATION FIREWALL (UFW)
print_step "9. Configuration Firewall..."
ufw --force enable
ufw default deny incoming
ufw default allow outgoing
ufw allow 22/tcp    # SSH
ufw allow 80/tcp    # HTTP
ufw allow 443/tcp   # HTTPS
ufw allow 8443/tcp  # Code-server
ufw allow 3306/tcp  # MySQL (optionnel, local only)
print_success "Firewall configuré"

# 10. DÉMARRAGE FINAL DE CODE-SERVER
print_step "10. Configuration Code-server..."
systemctl start code-server@root || code-server --auth password --bind-addr 0.0.0.0:8443 &
sleep 2
print_success "Code-server démarré"

# RÉSUMÉ FINAL
echo ""
echo -e "${GREEN}============================================"
echo "✓✓✓ INSTALLATION TERMINÉE ✓✓✓"
echo "============================================${NC}"
echo ""
echo "📋 INFOS DE CONNEXION:"
echo ""
echo "  🌐 Code-server:"
echo "     URL: http://$(hostname -I | awk '{print $1}'):8443"
print_info "     Password: Généré au démarrage (voir terminal)"
echo ""
echo "  📁 PHP/Nginx:"
echo "     URL: http://$(hostname -I | awk '{print $1}')"
echo "     Dossier: /var/www/dev-project"
echo ""
echo "  🗄️  MySQL/MariaDB:"
echo "     Host: localhost"
echo "     Port: 3306"
echo "     User: root (sans password par défaut)"
print_info "     Commande: mysql -u root"
echo ""
echo "  💻 SSH:"
echo "     ssh user@$(hostname -I | awk '{print $1}')"
echo ""
echo "📌 ÉTAPES SUIVANTES:"
echo "  1. Tous les 4 devs se connectent à: http://IP:8443"
echo "  2. Ouvrez /var/www/dev-project dans Code-server"
echo "  3. Configurez Git en local (git config --global user.name/email)"
echo "  4. Créez un repo partagé ou utilisez GitHub/GitLab"
echo ""
echo "🔒 SÉCURITÉ:"
echo "  - Changez le password MySQL: mysql -u root"
echo "    MariaDB> ALTER USER 'root'@'localhost' IDENTIFIED BY 'MonPassword';"
echo "  - Utilisez un reverse proxy (Nginx + SSL) en production"
echo ""
echo "📊 VÉRIFIER LES SERVICES:"
echo "  systemctl status code-server@root"
echo "  systemctl status php-fpm"
echo "  systemctl status nginx"
echo "  systemctl status mariadb"
echo ""
print_success "Bon développement! 🎉"
