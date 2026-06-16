# ================================
# Stage 1: Build frontend assets
# ================================
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install node dependencies
RUN npm ci --no-audit --prefer-offline

# Copy source for building
COPY . .

# Build frontend assets (Vite/Mix)
RUN npm run build

# ================================
# Stage 2: PHP/Laravel Production
# ================================
FROM php:8.2-fpm-alpine AS production

LABEL maintainer="your-name"
LABEL description="Laravel + Filament on ARM64"

# ── System dependencies ──────────────────────────────────────────
RUN apk add --no-cache \
    nginx \
    supervisor \
    git \
    curl \
    zip \
    unzip \
    bash \
    # PHP extension dependencies
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    libxml2-dev \
    oniguruma-dev \
    icu-dev \
    # MySQL client
    mysql-client

# ── PHP Extensions ───────────────────────────────────────────────
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        zip \
        gd \
        bcmath \
        xml \
        opcache \
        intl \
        pcntl \
        exif

# ── Composer ─────────────────────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ── PHP config ───────────────────────────────────────────────────
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "upload_max_filesize=64M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=64M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/memory.ini

# ── App setup ────────────────────────────────────────────────────
WORKDIR /var/www/html

# Copy composer files first (layer cache optimization)
COPY composer.json composer.lock ./

# Install PHP dependencies (no dev, optimized)
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction

# Copy the rest of the application
COPY . .

# Copy built frontend assets from node stage
COPY --from=node-builder /app/public/build ./public/build

# Run composer autoloader dump with scripts
RUN composer dump-autoload --optimize --no-dev

# ── Permissions ───────────────────────────────────────────────────
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# ── Nginx config ──────────────────────────────────────────────────
COPY docker/nginx.conf /etc/nginx/nginx.conf

# ── Supervisor config ─────────────────────────────────────────────
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ── Start script ──────────────────────────────────────────────────
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8000

CMD ["/start.sh"]
