# ps-script-general.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "🔧 Fixing Memory Limit for Shop" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Yellow

# Update start.sh
Write-Host ""
Write-Host "[1/3] Updating start.sh with memory limit..."

$startContent = @'
#!/bin/bash
set -e

echo "========================================"
echo "🚀 STARTING CONTAINER"
echo "========================================"

echo "==> Setting PHP memory limit to 256M..."
echo "memory_limit = 256M" > /usr/local/etc/php/conf.d/memory-limit.ini

echo "==> Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Creating storage link..."
php artisan storage:link || true

echo "==> Clearing caches..."
php artisan optimize:clear

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Starting PHP-FPM..."
php-fpm -D

echo "==> Starting Nginx..."
nginx -g 'daemon off;'
'@

$startContent | Out-File -FilePath "docker/start.sh" -Encoding utf8
Write-Host "✅ Updated start.sh" -ForegroundColor Green

# Commit and push
Write-Host ""
Write-Host "[2/3] Committing changes..."
git add docker/start.sh
git commit -m "Fix: Increase PHP memory limit to 256M for shop"
git push origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Pushed to GitHub" -ForegroundColor Green
} else {
    Write-Host "❌ Push failed. Please check your Git connection." -ForegroundColor Red
}

Write-Host ""
Write-Host "[3/3] Done!" -ForegroundColor Green
Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "✅ Redeploy on Railway!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan

Read-Host 'Press Enter to exit'