#!/bin/bash

################################################################################
# HOSTINGER DEPLOYMENT SCRIPT - COMPLETE SETUP
# E-Commerce Muebles Melamina
# Clones repository and performs full production setup
################################################################################

set -e  # Exit on any error

echo "=================================================="
echo "🚀 HOSTINGER DEPLOYMENT SCRIPT"
echo "E-Commerce Muebles Melamina"
echo "=================================================="
echo ""

# Configuration
DOMAIN_PATH="$HOME/domains/mobelsalejandro.shop"
PUBLIC_HTML="$DOMAIN_PATH/public_html"
REPO_URL="https://github.com/guilleq18/mobels_alejandro.git"
DB_HOST="localhost"
DB_NAME="u519347385_mobels"
DB_USER="u519347385_mbaguero"
DB_PASS="Alejandro123!"
APP_EMAIL="alejandro.willi@gmail.com"
APP_NAME="Alejandro"

echo "📋 Configuration:"
echo "   Domain Path: $DOMAIN_PATH"
echo "   Public HTML: $PUBLIC_HTML"
echo "   Repository: $REPO_URL"
echo ""

# Step 1: Backup existing data (if any)
if [ -d "$PUBLIC_HTML" ]; then
    echo "⚠️  Backing up existing public_html..."
    BACKUP_DIR="$DOMAIN_PATH/public_html.backup.$(date +%s)"
    mv "$PUBLIC_HTML" "$BACKUP_DIR"
    echo "✓ Backup created at: $BACKUP_DIR"
    echo ""
fi

# Step 2: Create fresh public_html directory
echo "📁 Creating fresh public_html directory..."
mkdir -p "$PUBLIC_HTML"
cd "$PUBLIC_HTML"
echo "✓ Directory created and ready"
echo ""

# Step 3: Clone repository
echo "📥 Cloning repository from GitHub..."
git clone "$REPO_URL" .
git config user.email "$APP_EMAIL"
git config user.name "$APP_NAME"
echo "✓ Repository cloned successfully"
echo ""

# Step 4: Install PHP dependencies
echo "📦 Installing PHP dependencies with Composer..."
echo "   (This may take 5-10 minutes...)"
composer install --no-dev --optimize-autoloader
echo "✓ Composer dependencies installed"
echo ""

# Step 5: Configuration
echo "⚙️  Setting up environment configuration..."

# Check if .env exists, if not create from example
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "✓ .env created from .env.example"
else
    echo "✓ .env already exists"
fi

# Update .env with production values
echo "   Updating database configuration..."
sed -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
sed -i "s|APP_URL=.*|APP_URL=https://mobelsalejandro.shop|" .env
sed -i "s/APP_DEBUG=.*/APP_DEBUG=false/" .env
echo "✓ Environment variables updated"
echo ""

# Step 6: Generate application key (if not set)
echo "🔐 Generating application key..."
php artisan key:generate
echo "✓ Application key generated"
echo ""

# Step 7: Database setup
echo "🗄️  Setting up database..."
echo "   Running migrations..."
php artisan migrate --force
echo "✓ Migrations completed"
echo ""

echo "   Seeding database..."
php artisan db:seed
echo "✓ Database seeded with initial data"
echo ""

# Step 8: Verify installation
echo "✅ Verification..."
php artisan tinker --execute="echo 'Users: ' . count(\App\Models\User::all());"
echo "✓ Installation verified"
echo ""

# Step 9: Permissions (if needed)
echo "🔒 Setting permissions..."
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
echo "✓ Permissions set"
echo ""

# Step 10: Cache and optimization
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✓ Caching optimized"
echo ""

echo "=================================================="
echo "✨ DEPLOYMENT COMPLETE!"
echo "=================================================="
echo ""
echo "📋 Next Steps:"
echo ""
echo "1. Verify website access:"
echo "   https://mobelsalejandro.shop"
echo ""
echo "2. Test admin login:"
echo "   https://mobelsalejandro.shop/admin/login"
echo "   Email: alejandro@example.com"
echo "   Password: password"
echo ""
echo "3. Check logs for any issues:"
echo "   tail -f storage/logs/laravel.log"
echo ""
echo "=================================================="
