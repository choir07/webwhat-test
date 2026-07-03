#!/bin/bash
set -e

echo "==> Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "==> Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Creating storage symlink..."
php artisan storage:link || true

echo "==> Clearing old caches..."
php artisan cache:clear

echo "==> Done. Starting server..."