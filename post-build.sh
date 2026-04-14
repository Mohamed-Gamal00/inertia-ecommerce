#!/bin/bash

# Post-build script for Railway - runs after default build

echo "🔧 Running post-build optimizations..."

# Ensure directories exist with proper permissions
mkdir -p storage/framework/{sessions,views,cache,testing}
mkdir -p storage/logs
mkdir -p bootstrap/cache
mkdir -p public/build
chmod -R 775 storage bootstrap/cache public/build

# Clear any existing caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Cache configurations (skip route cache to avoid conflicts)
php artisan config:cache
php artisan event:cache  
php artisan view:cache

# Create storage link if it doesn't exist
php artisan storage:link

echo "✅ Post-build completed!"