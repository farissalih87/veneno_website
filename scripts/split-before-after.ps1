<#
.SYNOPSIS
    Splits a composite Before/After image (vertical or horizontal split) into two synchronized images for the Veneno interactive slider.

.EXAMPLE
    .\scripts\split-before-after.ps1 -ImagePath "C:\path\to\image.jpg" -CarName "aston-martin-vantage" -SplitType "Vertical"
#>

param (
    [Parameter(Mandatory=$true)]
    [string]$ImagePath,

    [Parameter(Mandatory=$false)]
    [string]$CarName = "custom-vehicle",

    [Parameter(Mandatory=$false)]
    [ValidateSet("Vertical", "Horizontal")]
    [string]$SplitType = "Vertical",

    [Parameter(Mandatory=$false)]
    [string]$OutputDir = "d:\Veneno\Veneno_ae_Website\Gemini_veneno_website\public\images\before-after"
)

Add-Type -AssemblyName System.Drawing

if (!(Test-Path $ImagePath)) {
    Write-Error "Source image not found at: $ImagePath"
    exit 1
}

if (!(Test-Path $OutputDir)) {
    New-Item -ItemType Directory -Force -Path $OutputDir | Out-Null
}

$img = [System.Drawing.Image]::FromFile($ImagePath)
$w = $img.Width
$h = $img.Height

Write-Host "Processing image: $ImagePath" -ForegroundColor Cyan
Write-Host "Source Dimensions: $w x $h | Split Mode: $SplitType" -ForegroundColor Yellow

if ($SplitType -eq "Vertical") {
    # Top is Before, Bottom is After
    $halfH = [int]($h / 2)
    
    # Margin offset to avoid center dividing text/watermarks if present
    $centerPadding = [int]($h * 0.025)
    $cropH = $halfH - $centerPadding

    # 1. Before Image (Top)
    $rectBefore = [System.Drawing.Rectangle]::new(0, 0, $w, $cropH)
    $bmpBefore = [System.Drawing.Bitmap]::new($w, $cropH)
    $gBefore = [System.Drawing.Graphics]::FromImage($bmpBefore)
    $gBefore.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $gBefore.DrawImage($img, 0, 0, $rectBefore, [System.Drawing.GraphicsUnit]::Pixel)
    $beforePath = Join-Path $OutputDir "$CarName-before.jpg"
    $bmpBefore.Save($beforePath, [System.Drawing.Imaging.ImageFormat]::Jpeg)
    $gBefore.Dispose()
    $bmpBefore.Dispose()

    # 2. After Image (Bottom)
    $rectAfter = [System.Drawing.Rectangle]::new(0, ($halfH + $centerPadding), $w, $cropH)
    $bmpAfter = [System.Drawing.Bitmap]::new($w, $cropH)
    $gAfter = [System.Drawing.Graphics]::FromImage($bmpAfter)
    $gAfter.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $gAfter.DrawImage($img, 0, 0, $rectAfter, [System.Drawing.GraphicsUnit]::Pixel)
    $afterPath = Join-Path $OutputDir "$CarName-after.jpg"
    $bmpAfter.Save($afterPath, [System.Drawing.Imaging.ImageFormat]::Jpeg)
    $gAfter.Dispose()
    $bmpAfter.Dispose()
}
else {
    # Left is Before, Right is After
    $halfW = [int]($w / 2)
    $cropW = $halfW

    # 1. Before Image (Left)
    $rectBefore = [System.Drawing.Rectangle]::new(0, 0, $cropW, $h)
    $bmpBefore = [System.Drawing.Bitmap]::new($cropW, $h)
    $gBefore = [System.Drawing.Graphics]::FromImage($bmpBefore)
    $gBefore.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $gBefore.DrawImage($img, 0, 0, $rectBefore, [System.Drawing.GraphicsUnit]::Pixel)
    $beforePath = Join-Path $OutputDir "$CarName-before.jpg"
    $bmpBefore.Save($beforePath, [System.Drawing.Imaging.ImageFormat]::Jpeg)
    $gBefore.Dispose()
    $bmpBefore.Dispose()

    # 2. After Image (Right)
    $rectAfter = [System.Drawing.Rectangle]::new($halfW, 0, $cropW, $h)
    $bmpAfter = [System.Drawing.Bitmap]::new($cropW, $h)
    $gAfter = [System.Drawing.Graphics]::FromImage($bmpAfter)
    $gAfter.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $gAfter.DrawImage($img, 0, 0, $rectAfter, [System.Drawing.GraphicsUnit]::Pixel)
    $afterPath = Join-Path $OutputDir "$CarName-after.jpg"
    $bmpAfter.Save($afterPath, [System.Drawing.Imaging.ImageFormat]::Jpeg)
    $gAfter.Dispose()
    $bmpAfter.Dispose()
}

$img.Dispose()

Write-Host "Success! Created slider pair:" -ForegroundColor Green
Write-Host " - Before: $beforePath" -ForegroundColor White
Write-Host " - After:  $afterPath" -ForegroundColor White
