FROM php:8.4-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx nodejs npm postgresql-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev zip unzip curl oniguruma-dev \
    icu-dev libexif-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip bcmath mbstring intl exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
ARG APP_KEY
ENV APP_KEY=${APP_KEY}

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Publish Filament and Livewire assets into public/
RUN php artisan filament:assets || true
RUN php artisan vendor:publish --tag=livewire:assets --force || true

# Install Node dependencies and build assets
RUN npm ci --no-audit && chmod +x node_modules/.bin/vite && npm run build

# Copy Docker config files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 10000

ENTRYPOINT []
CMD ["/bin/sh", "/usr/local/bin/start.sh"]