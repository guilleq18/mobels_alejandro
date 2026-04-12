$ErrorActionPreference = 'Stop'

$projectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
$deployRoot = Join-Path $projectRoot 'deploy'
$packageRoot = Join-Path $deployRoot 'hostinger-clean'
$laravelAppRoot = Join-Path $packageRoot 'laravel_app'
$publicHtmlRoot = Join-Path $packageRoot 'public_html'
$zipPath = Join-Path $deployRoot 'hostinger-clean.zip'

Write-Host "Preparando paquete para Hostinger (subida manual)..."

if (Test-Path $packageRoot) {
    Remove-Item -LiteralPath $packageRoot -Recurse -Force
}

if (Test-Path $zipPath) {
    Remove-Item -LiteralPath $zipPath -Force
}

New-Item -ItemType Directory -Path $packageRoot | Out-Null
New-Item -ItemType Directory -Path $laravelAppRoot | Out-Null
New-Item -ItemType Directory -Path $publicHtmlRoot | Out-Null

# Items para Laravel - EXCLUYENDO package.json y vite.config.js
$itemsForLaravelApp = @(
    'app',
    'bootstrap',
    'config',
    'database',
    'resources',
    'routes',
    'storage',
    'vendor',
    'artisan',
    'composer.json',
    'composer.lock'
)

foreach ($item in $itemsForLaravelApp) {
    $sourcePath = Join-Path $projectRoot $item
    if (Test-Path $sourcePath) {
        Copy-Item -LiteralPath $sourcePath -Destination $laravelAppRoot -Recurse -Force
        Write-Host "Copiado: $item"
    }
}

# Limpiar SQLite
$sqlitePath = Join-Path $laravelAppRoot 'database\database.sqlite'
if (Test-Path $sqlitePath) {
    Remove-Item -LiteralPath $sqlitePath -Force
}

# Limpiar logs
$logsPath = Join-Path $laravelAppRoot 'storage\logs'
if (Test-Path $logsPath) {
    Get-ChildItem -Path $logsPath -Force | Remove-Item -Force -ErrorAction SilentlyContinue
}

# Copiar .env template
$envSource = Join-Path (Join-Path $projectRoot 'deployment') 'hostinger'
$envSource = Join-Path $envSource '.env.hostinger.example'
Copy-Item -LiteralPath $envSource -Destination (Join-Path $laravelAppRoot '.env') -Force

# Copiar public
Get-ChildItem -LiteralPath (Join-Path $projectRoot 'public') -Force | ForEach-Object {
    Copy-Item -LiteralPath $_.FullName -Destination $publicHtmlRoot -Recurse -Force
}

# Modificar index.php
$indexPath = Join-Path $publicHtmlRoot 'index.php'
$indexContent = Get-Content -LiteralPath $indexPath -Raw
$indexContent = $indexContent.Replace("__DIR__.'/../storage/", "__DIR__.'/../laravel_app/storage/")
$indexContent = $indexContent.Replace("__DIR__.'/../vendor/", "__DIR__.'/../laravel_app/vendor/")
$indexContent = $indexContent.Replace("__DIR__.'/../bootstrap/", "__DIR__.'/../laravel_app/bootstrap/")
Set-Content -LiteralPath $indexPath -Value $indexContent -NoNewline

# Crear .htaccess
$htaccessContent = @"
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^`$` public/ [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/`$1 [L]
</IfModule>
"@
Set-Content -LiteralPath (Join-Path $packageRoot '.htaccess') -Value $htaccessContent

# Comprimir
Compress-Archive -Path (Join-Path $packageRoot '*') -DestinationPath $zipPath -Force

Write-Host ""
Write-Host "================================"
Write-Host "PAQUETE LISTO"
Write-Host "================================"
Write-Host "Archivo: $zipPath"
Write-Host ""
Write-Host "PASOS:"
Write-Host "1. Descarga el ZIP"
Write-Host "2. En Hostinger: Despliegues > cambiar Framework a 'Other'"
Write-Host "3. Sube el ZIP en cPanel > Administrador de Archivos"
Write-Host ""
