# 🐛 FIX: "fatal: not in a git directory" Error

## Your Current Situation

```
[u519347385@br-asc-web1663 public_html]$ git config user.email "alejandro.willi@gmail.com"
fatal: not in a git directory
```

**Cause:** The repository hasn't been cloned yet. The `public_html` folder exists but is empty of git files.

---

## ✅ QUICK FIX (Copy & Paste These Commands)

Run these **one at a time** in your SSH terminal:

### Step 1: Verify You're in the Right Place
```bash
pwd
```

Should output:
```
/home/u519347385/domains/mobelsalejandro.shop/public_html
```

If not, navigate there:
```bash
cd ~/domains/mobelsalejandro.shop/public_html
```

### Step 2: Check Current Contents
```bash
ls -la
```

If you see `.htaccess`, `index.html`, etc. but NO `.git/` folder, you're in the right place but need to clone.

### Step 3: Clone the Repository
```bash
git clone https://github.com/guilleq18/mobels_alejandro.git .
```

**Important:** The `.` at the end means "clone into current directory"

**Expected output:**
```
Cloning into '.'...
remote: Enumerating objects: 256, done.
remote: Counting objects: 100% (256/256), done.
remote: Compressing objects: 100% (189/189), done.
remote: Receiving objects: 100% (256/256), 2.34 MiB | 5.67 MiB/s, done.
remote: Resolving deltas: 100% (73/73), done.
```

**⏳ This takes 1-2 minutes. Wait for it to complete.**

### Step 4: Verify Clone Was Successful
```bash
ls -la
```

Now you should see:
```
.git/              ← This is the key!
app/
bootstrap/
public/
etc.
```

### Step 5: Configure Git (Now This Will Work!)
```bash
git config user.email "alejandro.willi@gmail.com"
git config user.name "Alejandro"
```

### Step 6: Verify Configuration
```bash
git config user.email
git config user.name
git status
```

Should show:
```
On branch main
Your branch is up to date with 'origin/main'.
nothing to commit, working tree clean
```

---

## ✅ IF CLONE FAILS

### Error: "fatal: destination path 'x' already exists"

**Cause:** Directory not empty

**Fix:**
```bash
# Option 1: Clean the directory
rm -rf public_html
mkdir public_html
cd public_html
git clone https://github.com/guilleq18/mobels_alejandro.git .

# Option 2: Move existing files
cd ~/domains/mobelsalejandro.shop
mv public_html public_html.backup
mkdir public_html
cd public_html
git clone https://github.com/guilleq18/mobels_alejandro.git .
```

### Error: "fatal: unable to access 'https://...' Could not resolve host"

**Cause:** No internet connection or GitHub is unreachable

**Fix:**
```bash
# Test connection
ping github.com

# If no response, wait a moment and try again
# If still fails, contact Hostinger support

# Try again
git clone https://github.com/guilleq18/mobels_alejandro.git .
```

### Error: "Please make sure you have the correct access rights"

**Cause:** SSH keys or authentication issue

**Fix:**
```bash
# Use HTTPS instead (already what we're using, so this shouldn't happen)
# But if it does, try:
git clone https://github.com/guilleq18/mobels_alejandro.git .

# If still fails, check git version:
git --version

# Update if needed:
sudo apt-get update
sudo apt-get install git
```

---

## ✅ AUTOMATED SCRIPT OPTION

If you want to run a script that does all this:

```bash
# Download and run the fix script
curl -sS https://raw.githubusercontent.com/guilleq18/mobels_alejandro/main/scripts/fix-deployment.sh | bash
```

Or manually run all steps together:

```bash
cd ~/domains/mobelsalejandro.shop/public_html && \
git clone https://github.com/guilleq18/mobels_alejandro.git . && \
git config user.email "alejandro.willi@gmail.com" && \
git config user.name "Alejandro" && \
git status && \
echo "✅ Git configured successfully!"
```

---

## ✅ NEXT STEPS AFTER FIX

Once git is configured, continue with:

```bash
# 1. Install dependencies
composer install --no-dev --optimize-autoloader

# 2. Setup environment
cp .env.example .env

# 3. Edit .env with database credentials
nano .env

# 4. Generate key
php artisan key:generate

# 5. Run migrations
php artisan migrate --force

# 6. Seed database
php artisan db:seed

# 7. Done!
echo "✅ Deployment complete!"
```

---

## 📊 QUICK REFERENCE

| What | Command |
|------|---------|
| Check location | `pwd` |
| List files | `ls -la` |
| Clone repo | `git clone https://github.com/guilleq18/mobels_alejandro.git .` |
| Check git status | `git status` |
| Set email | `git config user.email "alejandro.willi@gmail.com"` |
| Set name | `git config user.name "Alejandro"` |
| View config | `git config --list` |

---

## ✨ YOU'RE NOW READY!

After following these steps, run the full deployment guide:
→ [HOSTINGER_MANUAL_DEPLOYMENT.md](HOSTINGER_MANUAL_DEPLOYMENT.md)

Or use the quick reference:
→ [DEPLOYMENT_QUICK_REFERENCE.md](DEPLOYMENT_QUICK_REFERENCE.md)

---

**Status:** Instructions provided  
**Next:** Execute the clone command above
