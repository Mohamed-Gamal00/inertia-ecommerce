#!/bin/bash

# Laravel Railway startup script

echo "🚀 Starting Laravel application on Railway..."

# Set proper permissions for Laravel
echo "📁 Setting up directories and permissions..."
mkdir -p storage/framework/{sessions,views,cache,testing}
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Clear any existing cache first
echo "🧹 Clearing existing cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache configuration for production (only if no database errors)
echo "⚙️ Caching configuration..."
php artisan config:cache
php artisan event:cache

# Only cache routes if they don't have conflicts
echo "🛣️ Attempting to cache routes..."
if php artisan route:cache; then
    echo "✅ Routes cached successfully"
else
    echo "⚠️ Route caching failed, continuing without route cache"
fi

# Cache views
php artisan view:cache

# Run migrations if database is available
if [ ! -z "$MYSQLHOST" ] && [ ! -z "$MYSQLDATABASE" ]; then
    echo "🗄️ Running database migrations..."
    php artisan migrate --force
else
    echo "⚠️ Database not configured, skipping migrations"
fi

# Start the application
echo "🌐 Starting web server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}