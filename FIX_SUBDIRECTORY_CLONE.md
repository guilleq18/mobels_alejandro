# ✅ FIX: Clone Created Subdirectory Instead of Direct Clone

## Your Situation

You ran:
```bash
git clone https://github.com/guilleq18/mobels_alejandro.git
```

This created:
```
public_html/
└── mobels_alejandro/
    ├── app/
    ├── bootstrap/
    ├── config/
    └── .git/
```

But you need:
```
public_html/
├── app/
├── bootstrap/
├── config/
└── .git/
```

---

## ✅ SOLUTION: Move Files Up One Level

Run these commands **one at a time**:

### Step 1: Move all files and folders up
```bash
mv mobels_alejandro/* .
```

### Step 2: Move hidden files (like .env, .git, etc.)
```bash
mv mobels_alejandro/.* . 2>/dev/null || true
```

The `2>/dev/null || true` suppresses errors for `.` and `..` directories.

### Step 3: Remove the now-empty subdirectory
```bash
rmdir mobels_alejandro
```

### Step 4: Verify the structure
```bash
ls -la
```

Should now show:
```
total XXX
drwxr-xr-x   app/
drwxr-xr-x   bootstrap/
drwxr-xr-x   config/
drwxr-xr-x   .git/          ← This is key!
-rw-r--r--    .env.example
-rw-r--r--    .gitignore
-rw-r--r--    composer.json
```

### Step 5: Configure git (NOW THIS WILL WORK!)
```bash
git config user.email "alejandro.willi@gmail.com"
git config user.name "Alejandro"
```

### Step 6: Verify git is working
```bash
git status
```

Expected output:
```
On branch main
Your branch is up to date with 'origin/main'.
nothing to commit, working tree clean
```

✅ **Success! Now continue with deployment.**

---

## 🚀 ONE-LINER SOLUTION

If you want to run it all at once:

```bash
mv mobels_alejandro/* . && mv mobels_alejandro/.* . 2>/dev/null || true && rmdir mobels_alejandro && git config user.email "alejandro.willi@gmail.com" && git config user.name "Alejandro" && git status
```

---

## ⚠️ IF SOMETHING WENT WRONG

### Error: "Directory not empty"
This means some files have the same names. Safe to ignore or use `--force`:
```bash
mv -f mobels_alejandro/* .
```

### Error: "No such file or directory"
The directory already moved successfully. Check ls -la to verify.

### Files still in mobels_alejandro/
Run the move commands again, then check hidden files:
```bash
ls -la mobels_alejandro/
```

---

## ✅ NEXT STEPS

After verifying `git status` works correctly:

### Continue with Full Deployment

Run the deployment sequence:

```bash
# 1. Install dependencies
composer install --no-dev --optimize-autoloader

# 2. Setup environment
cp .env.example .env

# 3. Edit environment file
nano .env

# 4. Generate application key
php artisan key:generate

# 5. Run database migrations
php artisan migrate --force

# 6. Seed database with initial data
php artisan db:seed

# 7. Set permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# 8. Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment complete!"
```

---

## 📋 VERIFICATION

After all steps, verify:

```bash
# Check file structure
ls -la | head -20

# Check git
git status
git log --oneline | head -5

# Check if Laravel responds
php artisan --version

# Test database connection
php artisan tinker
> User::count()
> exit
```

---

## 💡 WHAT YOU LEARNED

For future reference:

**Correct clone (into current directory):**
```bash
git clone https://github.com/user/repo.git .
```
The `.` means "into current directory"

**Wrong clone (creates subdirectory):**
```bash
git clone https://github.com/user/repo.git
```
This creates `repo/` subdirectory

**Fix for wrong clone:**
```bash
mv repo/* .
mv repo/.* . 2>/dev/null || true
rmdir repo
```

---

**Status:** Ready to execute  
**Next:** Run the move commands above
