# 📚 GIT CLONE: Correct vs Incorrect

## The Two Ways to Clone

### ❌ WRONG WAY (Creates Subdirectory)

```bash
cd ~/domains/mobelsalejandro.shop/public_html
git clone https://github.com/guilleq18/mobels_alejandro.git
```

**Result:**
```
public_html/
└── mobels_alejandro/          ← UNWANTED SUBDIRECTORY!
    ├── app/
    ├── bootstrap/
    ├── .git/
    └── composer.json
```

**Problem:** Extra directory level breaks everything  
**When this happens:** Can't run `git config` - "not in a git directory"

---

### ✅ CORRECT WAY (Clones Directly)

```bash
cd ~/domains/mobelsalejandro.shop/public_html
git clone https://github.com/guilleq18/mobels_alejandro.git .
```

**Note the `.` at the end!**

**Result:**
```
public_html/
├── app/
├── bootstrap/
├── config/
├── .git/              ← Correct!
└── composer.json
```

**Advantage:** Correct directory structure, can run git commands

---

## What if You Did It Wrong?

### You cloned without the `.`?

Run these to fix it:

```bash
# Move everything up one level
mv mobels_alejandro/* .
mv mobels_alejandro/.* . 2>/dev/null || true

# Remove the subdirectory
rmdir mobels_alejandro

# Verify
git status
```

### Still getting errors?

```bash
# Check what's in mobels_alejandro
ls -la mobels_alejandro/

# If it has more files, move them too
mv -f mobels_alejandro/* .

# Check directory is empty
ls mobels_alejandro/

# Remove it
rmdir mobels_alejandro
```

---

## ✅ CLONE COMMAND REFERENCE

| Command | Result | Use Case |
|---------|--------|----------|
| `git clone <url>` | Creates `repo/` subdirectory | Almost never - causes issues |
| `git clone <url> .` | Clones into current dir | ✅ ALWAYS use this on servers |
| `git clone <url> mydir` | Creates `mydir/` folder | When you want a specific folder name |

---

## 🎯 FOR YOUR PROJECT

**Always use this format:**

```bash
# Navigate to where you want files
cd ~/domains/mobelsalejandro.shop/public_html

# Clone with the trailing dot
git clone https://github.com/guilleq18/mobels_alejandro.git .

# Configure
git config user.email "alejandro.willi@gmail.com"
git config user.name "Alejandro"
```

---

## 💡 WHY THE DOT MATTERS

The `.` in Unix/Linux means "current directory"

- `git clone <url>` = "Create a folder with the repo contents"
- `git clone <url> .` = "Put repo contents into THIS folder"

For server deployments, you almost always want the dot!

---

## ✅ QUICK TEST

After cloning (with or without dot), verify with:

```bash
# Should work if clone was correct
git status

# Should show files directly, not in subdirectory
ls -la

# Should find .git directory
ls -la .git
```

---

## 📋 SUMMARY

| Situation | Command |
|-----------|---------|
| Deploy to server | `git clone <url> .` ← Always include dot |
| Got wrong structure | Use `mv` commands above to fix |
| Need verify | Run `git status` |

**Remember:** The `.` is crucial for server deployments! 🎯

---

**Quick Fixes:**
- Wrong clone: [FIX_SUBDIRECTORY_CLONE.md](FIX_SUBDIRECTORY_CLONE.md)
- No clone at all: [FIX_GIT_NOT_IN_DIRECTORY.md](FIX_GIT_NOT_IN_DIRECTORY.md)
