#!/bin/bash

# Post-build script for Railway - runs after default build

echo "🔧 Running post-build optimizations..."

# Ensure directories exist with proper permissions
mkdir -p storage/framework/{sessions,views,cache,testing}
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Cache configurations (skip route cache to avoid conflicts)
php artisan config:cache
php artisan event:cache  
php artisan view:cache

echo "✅ Post-build completed!"