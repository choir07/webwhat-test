#!/bin/sh
set -e

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Linking storage..."
php artisan storage:link || true

echo "==> Upgrading Filament..."
php artisan filament:upgrade || true

echo "==> Starting PHP-FPM..."
php-fpm -D

echo "==> Starting Nginx..."
nginx -g 'daemon off;'#!/bin/sh
php artisan migrate --force
php artisan storage:link
php-fpm &
nginx -g 'daemon off;'
