#!/bin/bash
set -e

echo '==> Running migrations...'
php artisan migrate --force

echo '==> Creating storage link...'
php artisan storage:link || true

exec php-fpm
