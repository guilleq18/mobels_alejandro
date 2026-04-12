# 🗺️ DEPLOYMENT JOURNEY MAP

## The Complete Deployment Path

```
┌─────────────────────────────────────────────────────────────────┐
│                    DEPLOYMENT STARTS HERE                       │
│                         You (Local)                             │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Open SSH to Hostinger
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│                     SSH CONNECTION                              │
│                  hostinger@domain.shop                          │
│                                                                 │
│  $ ssh user@mobelsalejandro.shop                               │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Navigate to domain
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│            NAVIGATE TO DOMAIN FOLDER                            │
│                                                                 │
│  $ cd ~/domains/mobelsalejandro.shop                            │
│  $ pwd  # Verify you're here                                    │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Remove old files, create fresh directory
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│            CREATE FRESH PUBLIC_HTML                             │
│                                                                 │
│  $ rm -rf public_html                                           │
│  $ mkdir -p public_html                                         │
│  $ cd public_html                                               │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Clone the repository
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│         CLONE GITHUB REPOSITORY (~1 minute)                     │
│                                                                 │
│  $ git clone https://github.com/guilleq18/mobels_alejandro.git  │
│  Cloning into '.'...                                            │
│  [████████████████████] 100% done ✓                             │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Configure git
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│              CONFIGURE GIT LOCALLY                              │
│                                                                 │
│  $ git config user.email "alejandro.willi@gmail.com"            │
│  $ git config user.name "Alejandro"                             │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Install dependencies
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│     INSTALL COMPOSER DEPENDENCIES (~10-15 minutes)              │
│                                                                 │
│  $ composer install --no-dev --optimize-autoloader              │
│  Installing dependencies from lock file                         │
│  [████████████████████] 100% - Wait here! ⏳                    │
│  ✓ Generating optimized autoload files                          │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Create .env file
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│             SETUP ENVIRONMENT FILE                              │
│                                                                 │
│  $ cp .env.example .env                                         │
│  $ nano .env  # Or use your editor                              │
│                                                                 │
│  Update these values:                                           │
│  - DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD              │
│  - APP_URL, APP_DEBUG, APP_ENV                                  │
│                                                                 │
│  Save: Ctrl+O → ENTER → Ctrl+X                                 │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Generate application key
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│         GENERATE APPLICATION KEY (~10 seconds)                  │
│                                                                 │
│  $ php artisan key:generate                                     │
│  Application key [base64:XXXXX...] set successfully. ✓          │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Run database migrations
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│        CREATE DATABASE TABLES (~1-2 minutes)                    │
│                                                                 │
│  $ php artisan migrate --force                                  │
│  Migrating: 2026_04_10_000100_create_categories_table           │
│  Migrated: 2026_04_10_000100_create_categories_table            │
│  Migrating: 2026_04_10_000200_create_products_table             │
│  Migrated: 2026_04_10_000200_create_products_table              │
│  [... more migrations ...]                                       │
│  ✓ Migration successful                                         │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Seed initial data
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│        POPULATE DATABASE WITH SEED DATA (~30 seconds)           │
│                                                                 │
│  $ php artisan db:seed                                          │
│  Database seeding completed successfully. ✓                     │
│                                                                 │
│  Now your database has:                                         │
│  - 1 Admin User (alejandro@example.com)                         │
│  - Product Categories                                           │
│  - Sample Products                                              │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Set file permissions
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│           SET FOLDER PERMISSIONS (~5 seconds)                   │
│                                                                 │
│  $ chmod -R 775 storage/                                        │
│  $ chmod -R 775 bootstrap/cache/                                │
│                                                                 │
│  This allows Laravel to write logs and cache files              │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Optimize for production
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│         CACHE FOR PRODUCTION (~10 seconds)                      │
│                                                                 │
│  $ php artisan config:cache                                     │
│  $ php artisan route:cache                                      │
│  $ php artisan view:cache                                       │
│                                                                 │
│  ✓ Caching complete - App will run faster                       │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Verify installation
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│         FINAL VERIFICATION (~1 minute)                          │
│                                                                 │
│  $ php artisan tinker                                           │
│  >>> User::all()                                                │
│  Collection {                                                   │
│    #items: [                                                    │
│      User {#4                                                   │
│        id: 1,                                                   │
│        name: "Alejandro",                                       │
│        email: "alejandro@example.com",                          │
│      }                                                          │
│    ]                                                            │
│  }                                                              │
│  >>> exit                                                       │
│                                                                 │
│  ✓ Database working perfectly                                   │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ TEST IN BROWSER
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│                  DEPLOYMENT COMPLETE! 🎉                        │
│                                                                 │
│  ✓ Website: https://mobelsalejandro.shop                        │
│  ✓ Admin: https://mobelsalejandro.shop/admin                    │
│                                                                 │
│  Login with:                                                    │
│  Email: alejandro@example.com                                   │
│  Password: password                                             │
│                                                                 │
│  🎊 YOUR APPLICATION IS LIVE ON HOSTINGER! 🎊                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## DECISION TREE: Which Guide to Use?

```
START
  │
  ├─ Do you want automation?
  │  │
  │  ├─ YES → Use HOSTINGER_DEPLOY_SCRIPT.sh
  │  │        (Fastest, just copy & paste)
  │  │
  │  └─ NO → Do you want to learn each step?
  │     │
  │     ├─ YES → Use HOSTINGER_MANUAL_DEPLOYMENT.md
  │     │        (Best for understanding)
  │     │
  │     └─ NO → Use DEPLOYMENT_QUICK_REFERENCE.md
  │            (Quick commands with minimal explanation)
  │
  └─ Something went wrong?
     │
     └─ Use TROUBLESHOOTING_FAQ.md
        (Search for your error message)
```

---

## FILE STRUCTURE AFTER DEPLOYMENT

```
~domains/mobelsalejandro.shop/public_html/
│
├── app/                          ← Application code
│   ├── Http/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/                    ← Framework bootstrap
│   ├── app.php
│   └── providers.php
│
├── config/                       ← Configuration files
│   ├── app.php
│   ├── database.php
│   ├── auth.php
│   └── ...
│
├── database/                     ← Database files
│   ├── migrations/
│   └── seeders/
│
├── public/                       ← Web server root
│   ├── index.php                 ← Entry point
│   ├── css/
│   ├── js/
│   └── images/
│
├── resources/                    ← View files
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/                       ← URL routes
│   └── web.php
│
├── storage/                      ← Logs and uploads
│   ├── logs/
│   ├── uploads/
│   └── app/
│
├── vendor/                       ← PHP dependencies
│   └── (auto-generated by composer)
│
├── .env                          ← Configuration ⚠️ SECRET
├── .env.example                  ← Template
├── composer.json                 ← PHP dependencies list
├── artisan                       ← Command tool
├── README.md
└── package.json
```

---

## DEPLOYMENT STATUS CHECKLIST

```
BEFORE DEPLOYMENT:
☐ SSH access verified
☐ This documentation open
☐ Coffee ready (for waiting!)

DURING DEPLOYMENT:
☐ Cloned repository
☐ Installed composer dependencies (WAITING HERE)
☐ Created .env file
☐ Generated application key
☐ Ran migrations
☐ Seeded database
☐ Set permissions
☐ Cached for production

AFTER DEPLOYMENT:
☐ Website loads: https://mobelsalejandro.shop
☐ Admin accessible: https://mobelsalejandro.shop/admin
☐ Login works: alejandro@example.com / password
☐ Products display
☐ Database has data
☐ No errors in logs

SUCCESS:
☑ ALL SYSTEMS GO! 🚀
```

---

## TROUBLESHOOTING FLOWCHART

```
Is something broken?
│
├─ Blank page?
│  └─ See TROUBLESHOOTING_FAQ.md
│     → "Issue: Website shows blank page"
│
├─ Database connection error?
│  └─ See TROUBLESHOOTING_FAQ.md
│     → "Issue: PDOException: SQLSTATE[28000]"
│
├─ Permission denied?
│  └─ See TROUBLESHOOTING_FAQ.md
│     → "Issue: Permission denied on storage/"
│
├─ Command not found?
│  └─ Check if dependencies are installed
│     Run: composer install again
│
├─ Migrations fail?
│  └─ See TROUBLESHOOTING_FAQ.md
│     → "Issue: Migrations fail with Column already exists"
│
└─ Something else?
   └─ Search TROUBLESHOOTING_FAQ.md for keywords
      Check storage/logs/laravel.log for errors
```

---

## COMMAND QUICK REFERENCE

| What | Command |
|------|---------|
| Connect SSH | `ssh user@mobelsalejandro.shop` |
| Go to dir | `cd ~/domains/mobelsalejandro.shop/public_html` |
| Clone repo | `git clone <url> .` |
| Install deps | `composer install --no-dev --optimize-autoloader` |
| Create .env | `cp .env.example .env` |
| Edit .env | `nano .env` |
| Gen key | `php artisan key:generate` |
| Migrate | `php artisan migrate --force` |
| Seed | `php artisan db:seed` |
| Permissions | `chmod -R 775 storage/` |
| Test DB | `php artisan tinker` |
| Clear cache | `php artisan cache:clear` |
| View logs | `tail -f storage/logs/laravel.log` |

---

## 🎯 GOAL

After following this deployment guide, you will have:

✅ Complete Laravel application deployed  
✅ Database configured and populated  
✅ Website accessible at https://mobelsalejandro.shop  
✅ Admin panel working  
✅ Products displaying  
✅ Shopping cart functional  
✅ All systems optimized for production  

**READY TO DEPLOY? Let's go! Pick a guide above and start.**

---

**Status:** Complete & Ready  
**Last Updated:** 2026-04-11
