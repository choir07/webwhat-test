#!/bin/sh
set -e

echo '==> Publishing assets...'
php artisan filament:assets
php artisan vendor:publish --tag=livewire:assets --force

echo '==> Caching config at runtime...'
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo '==> Running migrations...'
php artisan migrate --force --graceful

echo '==> Seeding Cloudinary URLs...'
php artisan db:seed --class=CloudinaryUrlSeeder --force

echo '==> Starting services...'
nginx
exec php-fpm
