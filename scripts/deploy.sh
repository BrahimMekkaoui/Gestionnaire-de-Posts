#!/bin/bash

# Exit on error
set -e

echo "🚀 Starting deployment..."

# Create deploy directory if it doesn't exist
mkdir -p deploy

echo "📁 Copying files to deploy directory..."
# Copy files to deploy directory (exclude unnecessary files)
rsync -av --delete \
    --exclude='.git' \
    --exclude='.github' \
    --exclude='node_modules' \
    --exclude='tests' \
    --exclude='.editorconfig' \
    --exclude='.env.example' \
    --exclude='.gitattributes' \
    --exclude='.gitignore' \
    --exclude='phpunit.xml' \
    --exclude='README.md' \
    --exclude='deploy' \
    . deploy/

cd deploy

echo "🔧 Setting up environment..."
# Copy .env file if it doesn't exist
if [ ! -f .env ]; then
    cp ../.env .
    # Update environment to production
    sed -i '' 's/APP_ENV=local/APP_ENV=production/' .env
    sed -i '' 's/APP_DEBUG=true/APP_DEBUG=false/' .env
fi

echo "📦 Installing production dependencies..."
composer install --no-dev --optimize-autoloader

# Create required directories
echo "📂 Setting up directories..."
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache

# Generate application key if it doesn't exist
if [ ! -f .env ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Cache configuration
echo "⚙️  Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment completed successfully!"
echo "You can now run the application with: php artisan serve --port=8000"
