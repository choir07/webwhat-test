#!/bin/sh
set -e

echo "memory_limit = 256M" > /usr/local/etc/php/conf.d/memory-limit.ini

echo "==> Publishing Filament assets..."
php artisan filament:assets

echo "==> Caching config at runtime..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan view:clear

echo "==> Running migrations..."
php artisan migrate --force --graceful

#echo "==> Seeding Cloudinary URLs..."
#php artisan db:seed --class=CloudinaryUrlSeeder --force

echo "==> Starting services..."
nginx
exec php-fpm

echo "==> Starting Laravel server on port 10000..."
php artisan serve --host=0.0.0.0 --port=10000