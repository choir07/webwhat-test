#!/bin/sh
php artisan migrate --force
php artisan storage:link
php-fpm &
nginx -g 'daemon off;'
