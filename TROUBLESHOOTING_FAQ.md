# Troubleshooting & FAQ - Hostinger Deployment

## Common Issues & Solutions

### ❌ Issue: "composer: command not found"

**Cause:** Composer not in PATH or not installed globally  
**Solution:**

```bash
# Option 1: Use local composer
php ~/composer.phar install --no-dev --optimize-autoloader

# Option 2: Install globally
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# Verify
composer --version
```

---

### ❌ Issue: "SQLSTATE[HY000]: General error: 1030"

**Cause:** Database disk space full or permission denied  
**Solutions:**

```bash
# Check disk space
df -h
du -sh ~/databases/

# Check MySQL error log
tail -100 /var/log/mysql/error.log

# Restart MySQL
/etc/init.d/mysql restart
```

---

### ❌ Issue: "PDOException: SQLSTATE[28000]"

**Cause:** Wrong database credentials  
**Solution:**

```bash
# Verify credentials in .env
grep DB_ .env

# Test connection manually
php artisan tinker
> DB::connection()->getPdo();
> exit

# If failed, update .env
nano .env

# Then clear config cache
php artisan config:clear
php artisan config:cache
```

---

### ❌ Issue: Website shows blank page

**Cause:** Usually PHP error or missing files  
**Solution:**

```bash
# Check error log
tail -100 storage/logs/laravel.log

# Verify .env exists and has APP_KEY
grep APP_KEY .env

# Regenerate key
php artisan key:generate

# Verify public folder
ls -la public/

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

### ❌ Issue: "The streaming response to "GET /admin" was already started"

**Cause:** Headers already sent, usually double php.ini headers  
**Solution:**

```bash
# Clear output buffering
php artisan config:clear
php artisan view:clear

# Check for BOM in PHP files
grep -r $'\xEF\xBB\xBF' app/ | head -5

# Remove BOM if found
find . -type f -name "*.php" -exec sed -i '1s/^\xEF\xBB\xBF//' {} +
```

---

### ❌ Issue: "Call to undefined function" in storage/uploads

**Cause:** Missing storage symlink or permissions  
**Solution:**

```bash
# Create symlink
php artisan storage:link

# Verify symlink
ls -la public/ | grep storage

# Set permissions
chmod -R 775 storage/uploads/
chmod -R 755 public/storage/
```

---

### ❌ Issue: "Class not found" or "Namespace error"

**Cause:** Outdated autoloader cache  
**Solution:**

```bash
# Dump autoloader
composer dump-autoload -o

# Or regenerate
composer install --no-dev --optimize-autoloader

# Verify
ls -la vendor/autoload.php
```

---

### ❌ Issue: Admin panel 404 or not found

**Cause:** Routes not cached or rewrite rules missing  
**Solution:**

```bash
# Clear route cache
php artisan route:clear
php artisan route:cache

# Verify routes
php artisan route:list | grep admin

# Check .htaccess in public/
cat public/.htaccess
```

---

### ❌ Issue: Images/uploads not displaying

**Cause:** Storage permissions or symlink missing  
**Solution:**

```bash
# Create symlink
php artisan storage:link

# Verify permissions
chmod -R 775 storage/uploads/
ls -la storage/uploads/

# Test image path
php artisan tinker
> collect(glob('storage/uploads/*'))->all();
> exit
```

---

### ❌ Issue: Migrations fail with "Column already exists"

**Cause:** Migrations run multiple times  
**Solution:**

```bash
# Check migration status
php artisan migrate:status

# If duplicate, check database
php artisan tinker
> Schema::hasTable('migrations');
> DB::table('migrations')->get();
> exit

# Reset and reseed (WARNING: deletes data!)
php artisan migrate:reset --force
php artisan migrate --force
php artisan db:seed
```

---

### ❌ Issue: "Permission denied" on storage/ folders

**Cause:** Wrong ownership or permissions  
**Solution:**

```bash
# Get current user
whoami

# Fix permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# More permissive (if needed)
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/

# Verify
ls -la storage/ | head -5
```

---

### ❌ Issue: Application key missing

**Cause:** No APP_KEY in .env  
**Solution:**

```bash
# Check .env
grep APP_KEY .env

# If empty, generate
php artisan key:generate

# Verify
grep APP_KEY .env | head -1
```

---

### ❌ Issue: "Localhost refused to connect"

**Cause:** PHP not running or wrong port  
**Solution:**

```bash
# Check if PHP-FPM is running
sudo systemctl status php-fpm

# Check listening ports
netstat -tlnp | grep php

# Restart PHP-FPM
sudo systemctl restart php-fpm

# Restart Apache/Nginx
sudo systemctl restart apache2  # or: nginx
```

---

### ❌ Issue: Composer "requires ext-gd" missing

**Cause:** PHP GD extension not installed  
**Solution:**

```bash
# Contact Hostinger support to install:
# - php-gd
# - php-imagick
# - php-xml
# - php-mbstring

# Or install locally (if SSH access):
sudo apt-get install php-gd

# Verify
php -r "phpinfo();" | grep GD
```

---

## FAQ

### Q: How often should I backup the database?

**A:** Daily, especially before deployments. Set up cron job:

```bash
# Add to crontab
0 2 * * * mysqldump -u u519347385_mbaguero -p'Alejandro123!' u519347385_mobels > ~/backups/mobels_$(date +\%Y\%m\%d).sql
```

---

### Q: Can I update the code without losing data?

**A:** Yes, use:

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Q: How do I check if migrations are up to date?

**A:**

```bash
php artisan migrate:status
```

All should show "Ran" status.

---

### Q: Can I manually test database queries?

**A:** Yes, use Tinker:

```bash
php artisan tinker

# Examples:
> User::all();
> Product::count();
> Order::latest()->first();
> exit
```

---

### Q: How do I check what's consuming disk space?

**A:**

```bash
du -sh ~/* | sort -h
du -sh ~/domains/mobelsalejandro.shop/public_html/* | sort -h

# Find files larger than 100MB
find ~/domains/mobelsalejandro.shop -size +100M -type f
```

---

### Q: Can I run commands invisibly in background?

**A:** Yes, use `nohup`:

```bash
nohup php artisan queue:work > storage/logs/queue.log 2>&1 &
```

---

### Q: How do I debug email issues?

**A:**

```bash
# Test email configuration
php artisan tinker
> Mail::raw('Test', function($msg) { $msg->to('test@example.com'); });
> exit

# Check mail log
tail -50 storage/logs/laravel.log | grep -i mail
```

---

### Q: How do I clear all caches at once?

**A:**

```bash
php artisan cache:clear && \
php artisan config:clear && \
php artisan route:clear && \
php artisan view:clear && \
php artisan optimize:clear && \
echo "✅ All caches cleared"
```

---

### Q: What if I accidentally deleted something?

**A:**

```bash
# Check git history
git log --oneline | head -10

# Restore deleted file
git checkout HEAD -- path/to/file

# Or restore entire commit
git revert <commit-hash>
```

---

### Q: How do I check the application version?

**A:**

```bash
php artisan --version
cat composer.json | grep '"version"'
grep "const VERSION" app/Application.php
```

---

### Q: Can I test in production safely?

**A:** Use:

```bash
# Staging mode (read-only testing)
APP_DEBUG=true
APP_ENV=testing

# But don't deploy with these! Always use:
APP_DEBUG=false
APP_ENV=production
```

---

### Q: How do I optimize database?

**A:**

```bash
# Remove unused indexes
php artisan tinker
> DB::statement('OPTIMIZE TABLE users');
> DB::statement('OPTIMIZE TABLE products');
> exit

# Or full optimization
mysqldump -u user -p database | mysql -u user -p database
```

---

## Escalation Procedure

If you can't solve the issue:

1. **Collect information:**
   ```bash
   php artisan --version
   php -v
   mysql --version
   composer --version
   ```

2. **Gather logs:**
   ```bash
   tail -200 storage/logs/laravel.log > ~/laravel_error.log
   ```

3. **Contact Hostinger Support with:**
   - Error message (full stack trace)
   - Steps to reproduce
   - Screenshots
   - Output from commands above

---

**Document Status:** Complete
**Last Updated:** 2026-04-11
**For Project:** E-Commerce Muebles Melamina
