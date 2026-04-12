#!/usr/bin/env pwsh
# Script para hacer commit y push de los cambios del admin bypass

Write-Host "═══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "🚀 Sincronizando cambios de Admin Bypass" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# Verificar que estamos en el directorio correcto
$projectRoot = "e:\Dev\Projects\ecomerce_mobelsalejandro"
Set-Location $projectRoot

Write-Host "📁 Directorio: $projectRoot" -ForegroundColor Green
Write-Host ""

# Mostrar estado actual
Write-Host "📊 Estado actual de git:" -ForegroundColor Yellow
git status --short
Write-Host ""

# Agregar el archivo de rutas
Write-Host "📝 Agregando routes/web.php..." -ForegroundColor Yellow
git add routes/web.php

# Si hay cambios en otros archivos de documentación, también agregarlos
Write-Host "📝 Agregando archivos de documentación..." -ForegroundColor Yellow
git add ADMIN_BYPASS_ACCESS.md

# Verificar que hay cambios para commitear
$status = git status --porcelain
if ($status) {
    Write-Host "✅ Cambios detectados. Haciendo commit..." -ForegroundColor Green
    
    git commit -m "✨ Add admin bypass access route for development 

- Added /admin/bypass-login route for direct access
- Automatically creates and logs in alejandro@example.com user
- Useful for development and host testing
- Remove or protect this route before production"

    # Hacer push
    Write-Host "🚀 Haciendo push a main..." -ForegroundColor Green
    git push origin main
    
    Write-Host ""
    Write-Host "✅ COMMIT Y PUSH COMPLETADOS" -ForegroundColor Green
} else {
    Write-Host "⚠️  No hay cambios para commitear" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "═══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "📋 Próximos pasos en Hostinger:" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. SSH al servidor:"
Write-Host "   ssh u519347385@br-asc-web1663.hostinger.mx" -ForegroundColor Yellow
Write-Host ""
Write-Host "2. Ir al directorio:"
Write-Host "   cd ~/domains/mobelsalejandro.shop/public_html" -ForegroundColor Yellow
Write-Host ""
Write-Host "3. Actualizar código:"
Write-Host "   git pull origin main" -ForegroundColor Yellow
Write-Host ""
Write-Host "4. Acceder al admin en:"
Write-Host "   https://mobelsalejandro.shop/admin/bypass-login" -ForegroundColor Green
Write-Host ""
Write-Host "═══════════════════════════════════════════" -ForegroundColor Cyan
