# add-shop-redirect.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "🔄 Adding Shop Redirect" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Yellow

cd C:\Users\User\webwhat

# Check if routes/web.php exists
if (-not (Test-Path "routes/web.php")) {
    Write-Host "❌ routes/web.php not found!" -ForegroundColor Red
    exit 1
}

# Read the file
$content = Get-Content "routes/web.php" -Raw

# Check if redirect already exists
if ($content -match "Route::get\(\s*'\/'\s*,\s*function") {
    Write-Host "⚠️  Redirect already exists" -ForegroundColor Yellow
} else {
    # Add redirect after the <?php line
    $newContent = $content -replace "(\<\?php\s*)", '$1
// Redirect root to shop
Route::get("/", function () {
    return redirect("/shop");
});
'
    $newContent | Out-File "routes/web.php" -Encoding utf8
    Write-Host "✅ Added redirect to shop" -ForegroundColor Green
}

# Commit and push
git add routes/web.php
git commit -m "Redirect root to shop"
git push origin main

Write-Host ""
Write-Host "✅ Done! Deploying to Render..." -ForegroundColor Green
Write-Host "Your site will redirect to /shop automatically." -ForegroundColor Cyan
Read-Host "Press Enter to exit"