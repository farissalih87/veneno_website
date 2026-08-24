$ErrorActionPreference = "Stop"

$rootDir = "d:\Veneno\Veneno_ae_Website\Gemini_veneno_website"
$tempDir = Join-Path $env:TEMP "veneno_deploy_temp"
$zipFile = Join-Path $rootDir "veneno-ae-cpanel-deploy-update.zip"

Write-Host "Creating clean temporary staging directory at $tempDir..."
if (Test-Path $tempDir) {
    Remove-Item -Path $tempDir -Recurse -Force
}
New-Item -ItemType Directory -Path $tempDir | Out-Null

$itemsToCopy = @(
    "app",
    "bootstrap",
    "config",
    "database",
    "public",
    "resources",
    "routes",
    "storage",
    "vendor",
    ".env.production",
    ".env.example",
    ".htaccess",
    "artisan",
    "composer.json",
    "composer.lock",
    "package.json",
    "package-lock.json",
    "vite.config.js",
    "CPANEL_DEPLOY_GUIDE.md"
)

foreach ($item in $itemsToCopy) {
    $sourcePath = Join-Path $rootDir $item
    $destPath = Join-Path $tempDir $item
    if (Test-Path $sourcePath) {
        Write-Host "Copying $item..."
        Copy-Item -Path $sourcePath -Destination $destPath -Recurse -Force
    } else {
        Write-Warning "Item $item not found!"
    }
}

# Clean any temporary files inside temp staging
$sqliteDb = Join-Path $tempDir "database\database.sqlite"
if (Test-Path $sqliteDb) {
    Remove-Item $sqliteDb -Force
}

$hotFile = Join-Path $tempDir "public\hot"
if (Test-Path $hotFile) {
    Remove-Item $hotFile -Force
}

# Exclude heavy media folders (images and videos) as requested
$tempImages = Join-Path $tempDir "public\images"
if (Test-Path $tempImages) {
    Write-Host "Excluding public\images from deployment zip..."
    Remove-Item -Path $tempImages -Recurse -Force
}

$tempVideos = Join-Path $tempDir "public\videos"
if (Test-Path $tempVideos) {
    Write-Host "Excluding public\videos from deployment zip..."
    Remove-Item -Path $tempVideos -Recurse -Force
}

# Ensure storage directories exist
$storageDirs = @(
    "storage\app\public",
    "storage\framework\cache\data",
    "storage\framework\sessions",
    "storage\framework\views",
    "storage\logs",
    "bootstrap\cache"
)

foreach ($dir in $storageDirs) {
    $p = Join-Path $tempDir $dir
    if (!(Test-Path $p)) {
        New-Item -ItemType Directory -Path $p -Force | Out-Null
    }
    $keep = Join-Path $p ".gitignore"
    if (!(Test-Path $keep)) {
        Set-Content -Path $keep -Value "*`n!.gitignore`n"
    }
}

Get-ChildItem -Path (Join-Path $tempDir "storage\framework\views\*") -Exclude ".gitignore" -ErrorAction SilentlyContinue | Remove-Item -Force -Recurse
Get-ChildItem -Path (Join-Path $tempDir "storage\framework\cache\data\*") -Exclude ".gitignore" -ErrorAction SilentlyContinue | Remove-Item -Force -Recurse
Get-ChildItem -Path (Join-Path $tempDir "storage\framework\sessions\*") -Exclude ".gitignore" -ErrorAction SilentlyContinue | Remove-Item -Force -Recurse
Get-ChildItem -Path (Join-Path $tempDir "storage\logs\*") -Exclude ".gitignore" -ErrorAction SilentlyContinue | Remove-Item -Force -Recurse
Get-ChildItem -Path (Join-Path $tempDir "bootstrap\cache\*") -Exclude ".gitignore" -ErrorAction SilentlyContinue | Remove-Item -Force -Recurse

# Create .env from .env.production as default in staging
Copy-Item (Join-Path $tempDir ".env.production") (Join-Path $tempDir ".env") -Force

Write-Host "Compressing deployment package into $zipFile with tar.exe..."
if (Test-Path $zipFile) {
    Remove-Item $zipFile -Force
}

# Fast compression using native Windows tar
Push-Location $tempDir
try {
    & tar.exe -a -c -f $zipFile * .env .env.example .env.production .htaccess
} finally {
    Pop-Location
}

$zipSize = (Get-Item $zipFile).Length / 1MB
Write-Host "SUCCESS! Deployment zip generated: $zipFile ($([math]::Round($zipSize, 2)) MB)"

# Clean temp staging
Remove-Item -Path $tempDir -Recurse -Force
