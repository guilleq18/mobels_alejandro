# Manual Hostinger Deployment Guide
## E-Commerce Muebles Melamina

### Prerequisites
- SSH access to Hostinger account
- Git installed on server
- PHP 8.2+ with CLI
- Composer installed globally
- MySQL database credentials

### Deployment Steps

## STEP 1: Connect via SSH

```bash
ssh username@mobelsalejandro.shop
```

## STEP 2: Navigate to Domain

```bash
cd ~/domains/mobelsalejandro.shop
```

## STEP 3: Remove Old Files (if exists)

```bash
# CAREFUL: This removes existing public_html
rm -rf public_html

# Create fresh directory
mkdir -p public_html
cd public_html
```

## STEP 4: Clone Repository

```bash
git clone https://github.com/guilleq18/mobels_alejandro.git .
```

Expected output:
```
Cloning into '.'...
remote: Enumerating objects: XXX, done.
remote: Counting objects: 100% (XXX/XXX), done.
...
✓ done.
```

## STEP 5: Configure Git

```bash
git config user.email "alejandro.willi@gmail.com"
git config user.name "Alejandro"
```

## STEP 6: Install PHP Dependencies

```bash
composer install --no-dev --optimize-autoloader
```

**⏱️ This takes 5-15 minutes. Wait for completion.**

Expected final output:
```
Installing dependencies from lock file
...
✓ Generating optimized autoload files
```

## STEP 7: Create Environment File

```bash
cp .env.example .env
```

## STEP 8: Edit Environment Variables

```bash
nano .env
```

Find and update these variables:

```ini
APP_DEBUG=false
APP_URL=https://mobelsalejandro.shop

DB_HOST=localhost
DB_DATABASE=u519347385_mobels
DB_USERNAME=u519347385_mbaguero
DB_PASSWORD=Alejandro123!

MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your-email@mobelsalejandro.shop
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@mobelsalejandro.shop
```

Save and exit: **Ctrl+O → Enter → Ctrl+X**

## STEP 9: Generate Application Key

```bash
php artisan key:generate
```

Expected output:
```
Application key [base64:XXXXX...] set successfully.
```

## STEP 10: Run Database Migrations

```bash
php artisan migrate --force
```

Expected output:
```
Migration table created successfully.
Migrating: ...
```

## STEP 11: Seed Database

```bash
php artisan db:seed
```

Expected output:
```
Database seeding completed successfully.
```

## STEP 12: Set File Permissions

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

## STEP 13: Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## STEP 14: Verify Installation

```bash
php artisan tinker
```

Inside Tinker, run:
```
User::all()
exit
```

Should show user records.

---

## ✅ Verification Checklist

- [ ] Website loads: https://mobelsalejandro.shop
- [ ] Admin accessible: https://mobelsalejandro.shop/admin
- [ ] Login works with: alejandro@example.com / password
- [ ] Products display
- [ ] Cart functionality works
- [ ] Database queries return data

---

## ⚠️ Troubleshooting

### "composer: command not found"
```bash
php ~/composer.phar install --no-dev --optimize-autoloader
```

### "Database connection failed"
- Verify DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env
- Check if MySQL service is running

### "Permission denied" on storage/
```bash
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/
```

### Clear cache and rebuild
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔒 Production Security

After deployment, run:

```bash
# Set proper permissions
chmod 755 public/
chmod 750 storage/
chmod 750 bootstrap/cache/
chmod 750 storage/uploads/

# Verify sensitive files are protected
ls -la | grep -E '\.env|secret|key'
```

---

## 📊 Monitor Logs

```bash
# Real-time log monitoring
tail -f storage/logs/laravel.log

# Show last 50 lines
tail -50 storage/logs/laravel.log

# Search for errors
grep -i error storage/logs/laravel.log | tail -20
```

---

## 🔄 Updates After Deployment

When pulling new code:

```bash
cd ~/domains/mobelsalejandro.shop/public_html

git pull origin main

composer install --no-dev --optimize-autoloader

php artisan migrate --force

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📋 Useful Commands

```bash
# Check Laravel version
php artisan --version

# List all routes
php artisan route:list

# Check disk space
df -h

# Check PHP version
php -v

# Check Composer version
composer --version

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

---

**Last Updated:** 2026-04-11
**Project:** E-Commerce Muebles Melamina
**Status:** Production Ready
