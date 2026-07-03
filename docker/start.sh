#!/bin/sh
set -e

echo '==> Caching config at runtime...'
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo '==> Running migrations...'
php artisan migrate --force --graceful

echo '==> Creating storage link...'
php artisan storage:link || true

echo '==> Starting services...'
nginx
exec php-fpm
