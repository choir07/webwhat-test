#!/bin/sh
set -e

echo "memory_limit = 256M" > /usr/local/etc/php/conf.d/memory-limit.ini

echo "==> Publishing Filament assets..."
php artisan filament:assets

echo "==> DEBUG: APP_ENV is currently: $APP_ENV"
echo "==> DEBUG: Laravel resolves environment as:"
php artisan tinker --execute="echo app()->environment();"

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
nginx -g "daemon off;" &
NGINX_PID=$!
php-fpm --nodaemonize &
PHP_PID=$!
wait -n $NGINX_PID $PHP_PID
exit $?

