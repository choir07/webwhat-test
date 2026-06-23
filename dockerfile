FROM php:8.5.4-fpm-alpine

RUN apk add --no-cache nginx nodejs npm postgresql-dev libpng-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql opcache gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev \
    && npm install && npm run build \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000
CMD ["/start.sh"]FROM php:8.5.4-fpm-alpine

# Install dependencies
RUN apk add --no-cache nginx nodejs npm postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev \
    && npm install && npm run build \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan storage:link

COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000
CMD ["/start.sh"]
