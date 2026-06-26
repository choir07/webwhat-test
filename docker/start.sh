#!/bin/sh
set -e

echo "==> Clearing config cache..."
php artisan config:clear
php artisan cache:clear

echo "==> Caching fresh config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Linking storage..."
php artisan storage:link || true

echo "==> Upgrading Filament..."
php artisan filament:upgrade || true

echo "==> Starting PHP-FPM..."
php-fpm -D

echo "==> Starting Nginx..."
nginx -g 'daemon off;'