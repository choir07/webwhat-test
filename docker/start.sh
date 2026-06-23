#!/bin/sh
php artisan migrate --force
nginx -g 'daemon off;' &
php-fpm
