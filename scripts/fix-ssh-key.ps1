#!/usr/bin/env pwsh
# Script para regenerar claves SSH sin passphrase
# Uso: .\fix-ssh-key.ps1

Write-Host "🔑 REGENERAR CLAVES SSH SIN PASSPHRASE" -ForegroundColor Cyan
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host ""

$sshDir = "$env:USERPROFILE\.ssh"
$privateKey = "$sshDir\hostinger_key"
$publicKey = "$sshDir\hostinger_key.pub"

# Crear directorio .ssh si no existe
if (-not (Test-Path $sshDir)) {
    Write-Host "📁 Creando directorio .ssh..." -ForegroundColor Yellow
    New-Item -ItemType Directory -Path $sshDir | Out-Null
}

# Eliminar claves antiguas si existen
if (Test-Path $privateKey) {
    Write-Host "🗑️  Eliminando clave privada antigua..." -ForegroundColor Yellow
    Remove-Item -Path "$privateKey" -Force
}

if (Test-Path $publicKey) {
    Write-Host "🗑️  Eliminando clave pública antigua..." -ForegroundColor Yellow
    Remove-Item -Path "$publicKey" -Force
}

# Generar nuevas claves SIN passphrase
Write-Host "🔄 Generando nuevas claves RSA 4096-bit..." -ForegroundColor Yellow
ssh-keygen -t rsa -b 4096 -N "" -f $privateKey -C hostinger -q

Write-Host ""
Write-Host "✅ Claves generadas correctamente" -ForegroundColor Green
Write-Host ""

# Verificar que existen
Write-Host "🔍 Verificando claves..." -ForegroundColor Yellow
if ((Test-Path $privateKey) -and (Test-Path $publicKey)) {
    Write-Host "   ✓ Clave privada: $privateKey" -ForegroundColor Green
    Write-Host "   ✓ Clave pública: $publicKey" -ForegroundColor Green
} else {
    Write-Host "   ✗ Error: Las claves no se crearon" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "📋 PRÓXIMOS PASOS:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. Abre la clave pública en Notepad:" -ForegroundColor White
Write-Host "   notepad $publicKey" -ForegroundColor Cyan
Write-Host ""
Write-Host "2. Copia TODO el contenido (Ctrl+A → Ctrl+C)" -ForegroundColor White
Write-Host ""
Write-Host "3. Ve a: https://panel.hostinger.com" -ForegroundColor White
Write-Host "   → Avanzado → SSH → Claves SSH" -ForegroundColor White
Write-Host "   → Elimina clave vieja (si existe)" -ForegroundColor White
Write-Host "   → Agregar clave SSH → Pega el contenido" -ForegroundColor White
Write-Host ""
Write-Host "4. Espera 2-3 minutos" -ForegroundColor White
Write-Host ""
Write-Host "5. Conecta con:" -ForegroundColor White
Write-Host "   ssh -i `$env:USERPROFILE\.ssh\hostinger_key -p 65002 u519347385@147.79.84.18" -ForegroundColor Cyan
Write-Host ""
Write-Host "6. Una vez conectado, ejecuta:" -ForegroundColor White
Write-Host "   cd ~/public_html/laravel_app" -ForegroundColor Cyan
Write-Host "   php artisan db:seed" -ForegroundColor Cyan
Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
