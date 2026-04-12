# ⚡ QUICK REFERENCE CHECKLIST - HOSTINGER DEPLOYMENT

## One-Command Deployment (Copy & Paste)

```bash
cd ~/domains/mobelsalejandro.shop && rm -rf public_html && mkdir -p public_html && cd public_html && git clone https://github.com/guilleq18/mobels_alejandro.git . && git config user.email "alejandro.willi@gmail.com" && git config user.name "Alejandro" && composer install --no-dev --optimize-autoloader && cp .env.example .env && nano .env
```

**After nano closes, continue with:**

```bash
php artisan key:generate && php artisan migrate --force && php artisan db:seed && chmod -R 775 storage/ && chmod -R 775 bootstrap/cache/ && php artisan config:cache && php artisan route:cache && php artisan view:cache && echo "✅ DEPLOYMENT COMPLETE!"
```

---

## .env Values to Update (in nano)

```ini
APP_DEBUG=false
APP_URL=https://mobelsalejandro.shop

DB_HOST=localhost
DB_DATABASE=u519347385_mobels
DB_USERNAME=u519347385_mbaguero
DB_PASSWORD=Alejandro123!
```

---

## Verification Commands

```bash
# Test website
curl -I https://mobelsalejandro.shop

# Check database
php artisan tinker
> User::count()
> exit

# View logs
tail -f storage/logs/laravel.log
```

---

## Time Estimates

| Step | Duration |
|------|----------|
| Clone Repository | 1 min |
| Composer Install | 8-15 min |
| Database Setup | 2 min |
| Total | ~15-20 min |

---

## File Structure After Deployment

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── .env ✓
├── .env.example
├── artisan
├── composer.json
└── composer.lock
```

---

## Admin Login After Deployment

```
URL: https://mobelsalejandro.shop/admin/login
Email: alejandro@example.com
Password: password
```

---

## If Something Goes Wrong

### Restore from backup
```bash
cd ~/domains/mobelsalejandro.shop
mv public_html.backup.TIMESTAMP public_html
```

### Reset database
```bash
cd public_html
php artisan migrate:reset --force
php artisan migrate --force
php artisan db:seed
```

### Clear all caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Check permissions
```bash
ls -la storage/
# Should see: drwxr-xr-x for directories
```

---

## Post-Deployment Checklist

- [ ] Website loads at https://mobelsalejandro.shop
- [ ] Admin login works
- [ ] Products display correctly
- [ ] Cart functionality active
- [ ] No errors in storage/logs/laravel.log
- [ ] Database has records
- [ ] Images/uploads accessible

---

## Support Commands

```bash
# Show all running processes
ps aux | grep -E 'php|mysql'

# Check disk usage
du -sh ~/domains/mobelsalejandro.shop/public_html

# Find large files
find ~/domains/mobelsalejandro.shop/public_html -size +10M

# Check file permissions
stat ~/domains/mobelsalejandro.shop/public_html/.env
```

---

**Status:** Ready for Hostinger Deployment
**Last Updated:** 2026-04-11
**Repository:** https://github.com/guilleq18/mobels_alejandro
