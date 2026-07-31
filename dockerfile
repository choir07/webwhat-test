FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    nginx nodejs npm postgresql-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev zip unzip curl oniguruma-dev \
    icu-dev libexif-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip bcmath mbstring intl exif
    && rm -f /usr/local/etc/php-fpm.d/docker.conf

RUN echo "listen = 9000" > /usr/local/etc/php-fpm.d/zz-custom.conf \
    && echo "listen.allowed_clients = " >> /usr/local/etc/php-fpm.d/zz-custom.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN npm ci --no-audit && chmod +x node_modules/.bin/vite && npm run build

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 10000

ENTRYPOINT []
CMD ["/bin/sh", "/usr/local/bin/start.sh"]