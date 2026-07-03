#!/bin/bash
set -e

echo "==> Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Clearing old caches..."
php artisan optimize:clear

echo "==> Starting PHP-FPM..."
php-fpm -D

echo "==> Starting Nginx..."
nginx -g 'daemon off;'
