#!/bin/bash

# Railway deployment script - runs during build phase

echo "🚀 Railway deployment starting..."

# Create necessary directories
echo "📁 Creating Laravel directories..."
mkdir -p storage/framework/{sessions,views,cache,testing}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache

# Install dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
echo "🎨 Building frontend assets..."
npm ci
npm run build

# Cache only safe configurations
echo "⚙️ Caching configuration..."
php artisan config:cache
php artisan event:cache
php artisan view:cache

# Skip route caching during build to avoid conflicts
echo "⚠️ Skipping route cache during build (will be done at runtime)"

echo "✅ Build phase completed successfully!"