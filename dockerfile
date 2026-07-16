FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    nginx nodejs npm postgresql-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev zip unzip curl oniguruma-dev \
    icu-dev libexif-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip bcmath mbstring intl exif

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev

# ✅ Set a dummy APP_KEY so artisan commands work during build
ENV APP_KEY=base64:iGOjMOMHbQcXXolaxDx42uh5rHv5G0eYfw1okrX/7u4=

# ✅ Publish Filament and Livewire assets during BUILD
RUN php artisan filament:assets || true
RUN php artisan vendor:publish --tag=livewire:assets --force || true

RUN npm ci --no-audit && chmod +x node_modules/.bin/vite && npm run build

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 10000

ENTRYPOINT []
CMD ["/bin/sh", "/usr/local/bin/start.sh"]