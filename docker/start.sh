#!/bin/bash
set -e

echo "==> Clearing old caches..."
php artisan optimize:clear

echo "==> Starting PHP-FPM..."
php-fpm -D

echo "==> Starting Nginx..."
nginx -g 'daemon off;'
