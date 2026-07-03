# ps-script-general.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "🔍 Diagnosing Blank Page Issue" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Yellow

# Step 1: Update start.sh with debug output
Write-Host ""
Write-Host "[1/3] Updating start.sh with debug output..." -ForegroundColor Yellow

$content = @'
#!/bin/bash
set -e

echo "==> Debug: Checking files..."
ls -la /var/www/html/public/index.php || echo "❌ index.php not found"
ls -la /var/www/html/.env || echo "⚠️ .env file missing"

echo "==> Debug: PHP version..."
php -v

echo "==> Debug: Checking Laravel..."
php artisan --version || echo "❌ Laravel command failed"

echo "==> Debug: Checking extensions..."
php -m | grep -E "pdo|pgsql|mbstring|json" || echo "⚠️ Missing extensions"

echo "==> Debug: Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || echo "⚠️ Permission issue"
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || echo "⚠️ Permission issue"

echo "==> Debug: Clearing caches..."
php artisan optimize:clear || echo "❌ optimize:clear failed"

echo "==> Debug: Config cache..."
php artisan config:cache || echo "❌ config:cache failed"

echo "==> Starting PHP-FPM..."
php-fpm -D

echo "==> Starting Nginx..."
nginx -g 'daemon off;'
'@

$content | Out-File -FilePath "docker/start.sh" -Encoding utf8
Write-Host "✅ Updated start.sh with debug output" -ForegroundColor Green

# Step 2: Commit and push
Write-Host ""
Write-Host "[2/3] Committing and pushing..." -ForegroundColor Yellow
git add docker/start.sh
git commit -m "Debug: Add verbose output to start.sh"
git push origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Pushed to GitHub successfully!" -ForegroundColor Green
} else {
    Write-Host "❌ Push failed. Check your Git connection." -ForegroundColor Red
}

# Step 3: Summary
Write-Host ""
Write-Host "[3/3] Done!" -ForegroundColor Yellow
Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "✅ Debug script deployed!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "📋 Next steps:" -ForegroundColor Yellow
Write-Host "   1. Go to Render Dashboard" -ForegroundColor White
Write-Host "   2. Click on webwhat-shop" -ForegroundColor White
Write-Host "   3. Click Logs tab" -ForegroundColor White
Write-Host "   4. Look for lines starting with '==> Debug:'" -ForegroundColor White
Write-Host "   5. Share the output with me" -ForegroundColor White

Read-Host "Press Enter to exit"