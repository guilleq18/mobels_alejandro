$ErrorActionPreference = 'Stop'

$projectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
$deployRoot = Join-Path $projectRoot 'deploy'
$packageRoot = Join-Path $deployRoot 'hostinger-package'
$laravelAppRoot = Join-Path $packageRoot 'laravel_app'
$publicHtmlRoot = Join-Path $packageRoot 'public_html'
$zipPath = Join-Path $deployRoot 'hostinger-package.zip'
$templateRoot = Join-Path $projectRoot 'deployment\hostinger'

if (Test-Path $packageRoot) {
    Remove-Item -LiteralPath $packageRoot -Recurse -Force
}

if (Test-Path $zipPath) {
    Remove-Item -LiteralPath $zipPath -Force
}

New-Item -ItemType Directory -Path $packageRoot | Out-Null
New-Item -ItemType Directory -Path $laravelAppRoot | Out-Null
New-Item -ItemType Directory -Path $publicHtmlRoot | Out-Null

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
    Copy-Item -LiteralPath (Join-Path $projectRoot $item) -Destination $laravelAppRoot -Recurse -Force
}

$sqlitePath = Join-Path $laravelAppRoot 'database\database.sqlite'
if (Test-Path $sqlitePath) {
    Remove-Item -LiteralPath $sqlitePath -Force
}

$logFiles = Join-Path $laravelAppRoot 'storage\logs\*'
if (Test-Path (Join-Path $laravelAppRoot 'storage\logs')) {
    Remove-Item -LiteralPath $logFiles -Force -ErrorAction SilentlyContinue
}

Copy-Item -LiteralPath (Join-Path $templateRoot '.env.hostinger.example') -Destination (Join-Path $laravelAppRoot '.env.hostinger.example') -Force

Get-ChildItem -LiteralPath (Join-Path $projectRoot 'public') -Force | ForEach-Object {
    Copy-Item -LiteralPath $_.FullName -Destination $publicHtmlRoot -Recurse -Force
}

$indexPath = Join-Path $publicHtmlRoot 'index.php'
$indexContent = Get-Content -LiteralPath $indexPath -Raw
$indexContent = $indexContent.Replace("__DIR__.'/../storage/", "__DIR__.'/../laravel_app/storage/")
$indexContent = $indexContent.Replace("__DIR__.'/../vendor/", "__DIR__.'/../laravel_app/vendor/")
$indexContent = $indexContent.Replace("__DIR__.'/../bootstrap/", "__DIR__.'/../laravel_app/bootstrap/")
Set-Content -LiteralPath $indexPath -Value $indexContent -NoNewline

Copy-Item -LiteralPath (Join-Path $templateRoot 'README.md') -Destination (Join-Path $packageRoot 'README-HOSTINGER.md') -Force

Compress-Archive -Path (Join-Path $packageRoot '*') -DestinationPath $zipPath -Force

Write-Host "Paquete generado en: $zipPath"
