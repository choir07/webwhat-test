#!/bin/sh
set -e

echo "==> DEBUG: docker.conf present at start.sh entry?"
ls -la /usr/local/etc/php-fpm.d/docker.conf 2>&1 || echo "NOT PRESENT"

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

echo "==> DEBUG: what's listening before FPM starts?"
netstat -tlnp 2>/dev/null || ss -tlnp 2>/dev/null || echo "no netstat/ss available"
echo "==> DEBUG: any php-fpm processes already running?"
ps aux | grep -i fpm || echo "none found"
NGINX_PID=$!
php-fpm --nodaemonize &
PHP_PID=$!
wait -n $NGINX_PID $PHP_PID
exit $?

