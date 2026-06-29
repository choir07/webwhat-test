# fix-blade-images.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "🖼️  Fixing Blade Image Tags" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Yellow

$filesToFix = @(
    "resources/views/blog/index.blade.php",
    "resources/views/blog/show.blade.php",
    "resources/views/blog/home.blade.php",
    "resources/views/blog/partials/related-slider.blade.php",
    "resources/views/welcome.blade.php"
)

$fixedCount = 0

foreach ($filePath in $filesToFix) {
    if (Test-Path $filePath) {
        Write-Host ""
        Write-Host "Checking: $filePath" -ForegroundColor Yellow
        
        $content = Get-Content $filePath -Raw
        
        # Check if it has the problematic pattern
        if ($content -match "asset\('storage/'.*?\$post->featured_image" -or $content -match 'asset\("storage/".*?\$post->featured_image') {
            Write-Host "  Found problematic image tag" -ForegroundColor Red
            
            # Create backup
            Copy-Item $filePath "$filePath.backup"
            Write-Host "  Backup created" -ForegroundColor Gray
            
            # Replace all variants
            $content = $content -replace "asset\('storage/' \. \$post->featured_image\)", '$post->featured_image'
            $content = $content -replace 'asset\("storage/" \. \$post->featured_image\)', '$post->featured_image'
            $content = $content -replace "asset\('storage/'\.\$post->featured_image\)", '$post->featured_image'
            $content = $content -replace 'asset\("storage/"\.\$post->featured_image\)', '$post->featured_image'
            
            # Also fix any other common patterns
            $content = $content -replace "asset\('storage/' \. \$post\['featured_image'\]\)", '$post->featured_image'
            $content = $content -replace 'asset\("storage/" \. \$post\[''featured_image''\]\)', '$post->featured_image'
            
            # Save the file
            $content | Out-File $filePath -Encoding UTF8
            Write-Host "  Fixed!" -ForegroundColor Green
            $fixedCount++
        } else {
            Write-Host "  No issues found" -ForegroundColor Green
        }
    } else {
        Write-Host "File not found: $filePath" -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Fixed $fixedCount file(s)!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan

Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "   1. Clear your browser cache" -ForegroundColor White
Write-Host "   2. Refresh your website" -ForegroundColor White
Write-Host "   3. If images still don't appear, we'll check manually" -ForegroundColor White

Read-Host "Press Enter to exit"