#!/bin/bash
set -e


echo "==> Caching config at runtime..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo '==> Running migrations...'
php artisan migrate --force

echo '==> Creating storage link...'
php artisan storage:link || true

exec php-fpm
