#!/bin/bash

# Laravel Railway startup script

echo "🚀 Starting Laravel application on Railway..."

# Ensure directories exist with proper permissions
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

# Clear any problematic cache
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache configurations safely
echo "⚙️ Caching configurations..."
php artisan config:cache
php artisan event:cache
php artisan view:cache

# Skip route caching to avoid naming conflicts
echo "⚠️ Skipping route cache due to naming conflicts"

# Run migrations if database is available
if [ ! -z "$MYSQLHOST" ] && [ ! -z "$MYSQLDATABASE" ]; then
    echo "🗄️ Running database migrations..."
    if php artisan migrate --force; then
        echo "✅ Migrations completed successfully"
    else
        echo "⚠️ Migration failed, continuing without database"
    fi
else
    echo "⚠️ Database not configured, skipping migrations"
fi

# Start the application
echo "🌐 Starting web server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}