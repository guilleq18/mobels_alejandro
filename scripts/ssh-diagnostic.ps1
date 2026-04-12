#!/usr/bin/env pwsh
# Script de diagnóstico SSH para Hostinger
# Uso: .\ssh-diagnostic.ps1

Write-Host "🔍 DIAGNÓSTICO SSH - MOBELS ALEJANDRO" -ForegroundColor Cyan
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host ""

# 1. Verificar que existe la clave privada
Write-Host "1️⃣  Verificando clave privada..." -ForegroundColor Yellow
$privateKeyPath = "$env:USERPROFILE\.ssh\hostinger_key"
if (Test-Path $privateKeyPath) {
    Write-Host "   ✓ Clave privada encontrada en: $privateKeyPath" -ForegroundColor Green
} else {
    Write-Host "   ✗ Clave privada NO encontrada" -ForegroundColor Red
    Write-Host "   Ejecuta: ssh-keygen -t rsa -b 4096 -N `"`" -f `$env:USERPROFILE\.ssh\hostinger_key -C hostinger" -ForegroundColor Yellow
}

Write-Host ""

# 2. Verificar que existe la clave pública
Write-Host "2️⃣  Verificando clave pública..." -ForegroundColor Yellow
$publicKeyPath = "$env:USERPROFILE\.ssh\hostinger_key.pub"
if (Test-Path $publicKeyPath) {
    Write-Host "   ✓ Clave pública encontrada en: $publicKeyPath" -ForegroundColor Green
    Write-Host "   Contenido de la clave (primera línea):" -ForegroundColor Gray
    $firstLine = Get-Content $publicKeyPath -Head 1
    Write-Host "   $($firstLine.Substring(0, [Math]::Min(60, $firstLine.Length)))..." -ForegroundColor Gray
} else {
    Write-Host "   ✗ Clave pública NO encontrada" -ForegroundColor Red
}

Write-Host ""

# 3. Verificar SSH-Agent
Write-Host "3️⃣  Verificando SSH-Agent..." -ForegroundColor Yellow
try {
    $sshAgentStatus = Get-Service ssh-agent -ErrorAction SilentlyContinue
    if ($sshAgentStatus.Status -eq "Running") {
        Write-Host "   ✓ SSH-Agent está corriendo" -ForegroundColor Green
    } else {
        Write-Host "   ⚠ SSH-Agent no está corriendo" -ForegroundColor Yellow
        Write-Host "   Ejecuta: Start-Service ssh-agent" -ForegroundColor Yellow
    }
} catch {
    Write-Host "   ⚠ No se pudo verificar SSH-Agent" -ForegroundColor Yellow
}

Write-Host ""

# 4. Intentar conexión SSH (sin ejecutar, solo mostrar comando)
Write-Host "4️⃣  Comando para conectar:" -ForegroundColor Yellow
Write-Host "   ssh -i `$env:USERPROFILE\.ssh\hostinger_key -p 65002 u519347385@147.79.84.18" -ForegroundColor Cyan

Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "PRÓXIMOS PASOS:" -ForegroundColor Yellow
Write-Host "1. Verifica que tu clave pública está en Hostinger (panel SSH keys)" -ForegroundColor Gray
Write-Host "2. Ejecuta el comando mostrado arriba para conectar" -ForegroundColor Gray
Write-Host "3. Si aún falla, ejecuta: Get-Help ssh" -ForegroundColor Gray
Write-Host ""
