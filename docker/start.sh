#!/bin/bash
set -e

echo "------------------------------------"
echo " Laravel + Filament Starting Up"
echo "------------------------------------"

cd /var/www/html

# ── Generate app key if not set ───────────────────────────────
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "⚡ Generating APP_KEY..."
    php artisan key:generate --force
fi

# ── Wait for database to be ready ─────────────────────────────
echo "⏳ Waiting for database connection..."
MAX_TRIES=30
COUNT=0
until php artisan db:show --no-interaction > /dev/null 2>&1; do
    COUNT=$((COUNT + 1))
    if [ $COUNT -ge $MAX_TRIES ]; then
        echo "❌ Database not reachable after ${MAX_TRIES} attempts. Check DB settings."
        exit 1
    fi
    echo "   Attempt $COUNT/$MAX_TRIES — retrying in 3s..."
    sleep 3
done
echo "✅ Database connected!"

# ── Run migrations ────────────────────────────────────────────
echo "🔄 Running migrations..."
php artisan migrate --force --no-interaction

# ── Cache for production ──────────────────────────────────────
echo "⚡ Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# ── Storage symlink ───────────────────────────────────────────
echo "🔗 Linking storage..."
php artisan storage:link --force 2>/dev/null || true

# ── Filament assets ───────────────────────────────────────────
echo "🎨 Publishing Filament assets..."
php artisan filament:assets 2>/dev/null || true

# ── Fix permissions ───────────────────────────────────────────
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "✅ All good! Starting services..."
echo "------------------------------------"

# ── Start supervisor (manages nginx + php-fpm + queue) ────────
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
