#!/usr/bin/env pwsh
# Script MEJORADO para regenerar claves SSH sin passphrase
# Maneja correctamente las rutas con espacios y caracteres especiales
# Uso: .\fix-ssh-key-improved.ps1

Write-Host "🔑 REGENERAR CLAVES SSH SIN PASSPHRASE (MEJORADO)" -ForegroundColor Cyan
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host ""

# Definir rutas correctamente
$sshDir = Join-Path $env:USERPROFILE ".ssh"
$privateKey = Join-Path $sshDir "hostinger_key"
$publicKey = "$privateKey.pub"

Write-Host "📍 Rutas:" -ForegroundColor Yellow
Write-Host "   SSH Dir: $sshDir" -ForegroundColor Gray
Write-Host "   Private Key: $privateKey" -ForegroundColor Gray
Write-Host "   Public Key: $publicKey" -ForegroundColor Gray
Write-Host ""

# Crear directorio .ssh si no existe
if (-not (Test-Path $sshDir)) {
    Write-Host "📁 Creando directorio .ssh..." -ForegroundColor Yellow
    New-Item -ItemType Directory -Path $sshDir -Force | Out-Null
    Write-Host "   ✓ Directorio creado" -ForegroundColor Green
}

# Eliminar claves antiguas si existen
if (Test-Path $privateKey) {
    Write-Host "🗑️  Eliminando clave privada antigua..." -ForegroundColor Yellow
    Remove-Item -Path $privateKey -Force -ErrorAction SilentlyContinue
    Write-Host "   ✓ Eliminada" -ForegroundColor Green
}

if (Test-Path $publicKey) {
    Write-Host "🗑️  Eliminando clave pública antigua..." -ForegroundColor Yellow
    Remove-Item -Path $publicKey -Force -ErrorAction SilentlyContinue
    Write-Host "   ✓ Eliminada" -ForegroundColor Green
}

Write-Host ""
Write-Host "🔄 Generando nuevas claves RSA 4096-bit..." -ForegroundColor Yellow

# Generar claves usando comillas apropiadas
try {
    & ssh-keygen -t rsa -b 4096 -N '""' -f $privateKey -C hostinger -q
    Write-Host "   ✓ Claves generadas correctamente" -ForegroundColor Green
} catch {
    Write-Host "   ✗ Error durante generación: $_" -ForegroundColor Red
    exit 1
}

Write-Host ""

# Verificar que existen
Write-Host "🔍 Verificando claves..." -ForegroundColor Yellow
$privateExists = Test-Path $privateKey
$publicExists = Test-Path $publicKey

if ($privateExists -and $publicExists) {
    Write-Host "   ✓ Clave privada: $privateKey" -ForegroundColor Green
    Write-Host "   ✓ Clave pública: $publicKey" -ForegroundColor Green
    
    # Mostrar primeros caracteres de la clave pública
    $pubContent = Get-Content $publicKey -Head 1
    $preview = if ($pubContent.Length -gt 60) { "$($pubContent.Substring(0, 60))..." } else { $pubContent }
    Write-Host "   📝 Inicio de clave: $preview" -ForegroundColor Gray
} else {
    Write-Host "   ✗ Error: Las claves no se crearon" -ForegroundColor Red
    Write-Host "   Private key exists: $privateExists" -ForegroundColor Red
    Write-Host "   Public key exists: $publicExists" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "📋 PRÓXIMOS PASOS:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1️⃣  Abre la clave pública en Notepad:" -ForegroundColor White
Write-Host "    notepad '$publicKey'" -ForegroundColor Cyan
Write-Host ""
Write-Host "2️⃣  Copia TODO el contenido (Ctrl+A → Ctrl+C)" -ForegroundColor White
Write-Host ""
Write-Host "3️⃣  Ve a: https://panel.hostinger.com" -ForegroundColor White
Write-Host "    • Avanzado → SSH → Claves SSH" -ForegroundColor White
Write-Host "    • Si hay clave vieja: Elimínala" -ForegroundColor White
Write-Host "    • Click 'Agregar clave SSH'" -ForegroundColor White
Write-Host "    • Pega el contenido (Ctrl+V)" -ForegroundColor White
Write-Host "    • Guarda/Confirma" -ForegroundColor White
Write-Host ""
Write-Host "4️⃣  ESPERA 2-3 MINUTOS (importante para sincronización)" -ForegroundColor Magenta
Write-Host ""
Write-Host "5️⃣  Conecta a Hostinger:" -ForegroundColor White
Write-Host "    ssh -i '$privateKey' -p 65002 u519347385@147.79.84.18" -ForegroundColor Cyan
Write-Host ""
Write-Host "6️⃣  Una vez conectado, configura Git y crea usuario admin:" -ForegroundColor White
Write-Host "    cd ~/public_html/laravel_app" -ForegroundColor Cyan
Write-Host "    git config user.email 'tu@email.com'" -ForegroundColor Cyan
Write-Host "    git config user.name 'Tu Nombre'" -ForegroundColor Cyan
Write-Host "    php artisan db:seed" -ForegroundColor Cyan
Write-Host ""
Write-Host "7️⃣  Ingresa al panel admin:" -ForegroundColor White
Write-Host "    https://mobelsalejandro.shop/admin/login" -ForegroundColor Cyan
Write-Host "    Email: alejandro@example.com" -ForegroundColor Cyan
Write-Host "    Password: password" -ForegroundColor Cyan
Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host ""
Write-Host "✅ ¡Listo! Las claves están generadas y listas para usar." -ForegroundColor Green
