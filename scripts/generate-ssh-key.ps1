# Generar clave SSH para Hostinger

Write-Host "Generando clave SSH para Hostinger..." -ForegroundColor Green

# Crear directorio .ssh si no existe
$sshDir = "$env:USERPROFILE\.ssh"
if (-not (Test-Path $sshDir)) {
    New-Item -ItemType Directory -Path $sshDir | Out-Null
}

# Generar clave
$keyPath = Join-Path $sshDir "hostinger_key"
ssh-keygen -t rsa -b 4096 -N "" -f $keyPath

Write-Host "`n✅ Claves generadas:" -ForegroundColor Green
Write-Host "Privada: $keyPath"
Write-Host "Pública: $keyPath.pub"

Write-Host "`n📋 Clave PRIVADA (copiar a GitHub Secret HOSTINGER_SSH_KEY):" -ForegroundColor Yellow
Write-Host "=" * 60
Get-Content $keyPath
Write-Host "=" * 60

Write-Host "`n📋 Clave PÚBLICA (copiar a Hostinger):" -ForegroundColor Yellow
Write-Host "=" * 60
Get-Content "$keyPath.pub"
Write-Host "=" * 60

Write-Host "`n✅ Pasos:" -ForegroundColor Green
Write-Host "1. Copia la CLAVE PRIVADA a GitHub: Settings → Secrets → HOSTINGER_SSH_KEY"
Write-Host "2. Copia la CLAVE PÚBLICA a Hostinger: Panel SSH → Agregar clave SSH"
