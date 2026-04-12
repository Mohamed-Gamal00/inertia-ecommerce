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

# Cache configuration for production
echo "⚙️ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations if database is available
if [ ! -z "$MYSQLHOST" ]; then
    echo "🗄️ Running database migrations..."
    php artisan migrate --force
fi

# Start the application
echo "🌐 Starting web server..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}