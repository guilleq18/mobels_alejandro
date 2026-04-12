#!/bin/bash
# IMMEDIATE FIX - Run this on Hostinger right now
# Execute in: ~/domains/mobelsalejandro.shop/public_html

echo "🔧 IMMEDIATE FIX FOR GIT ERROR"
echo "======================================"
echo ""

# Step 1: Verify location
echo "📍 Current location:"
pwd
echo ""

# Step 2: Check if git repo exists
if [ -d ".git" ]; then
    echo "✓ Git repository found"
else
    echo "✗ Git repository NOT found - cloning now..."
    
    # Step 3: Clone the repository
    echo "📥 Cloning repository..."
    git clone https://github.com/guilleq18/mobels_alejandro.git .
    
    if [ $? -eq 0 ]; then
        echo "✓ Repository cloned successfully"
    else
        echo "✗ Clone failed - check internet connection and try again"
        exit 1
    fi
fi

echo ""
echo "⚙️  Configuring git..."

# Step 4: Configure git
git config user.email "alejandro.willi@gmail.com"
git config user.name "Alejandro"

# Verify configuration
echo ""
echo "✓ Git configured:"
git config user.email
git config user.name

echo ""
echo "✓ Verify git is working:"
git status
echo ""
echo "✅ READY TO CONTINUE WITH DEPLOYMENT!"
