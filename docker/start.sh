#!/bin/sh
set -e

echo '==> Caching config at runtime...'
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo '==> Running migrations...'
php artisan migrate --force --graceful

echo '==> Seeding Cloudinary URLs...'
php artisan db:seed --class=CloudinaryUrlSeeder --force

echo '==> Publishing Filament assets...'
php artisan filament:assets

echo '==> Publishing Livewire assets...'
php artisan livewire:publish --assets

echo '==> Creating storage link...'
php artisan storage:link || true

echo '==> Starting services...'
nginx
exec php-fpm
