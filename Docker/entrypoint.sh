#!/bin/bash

# Run migrations
php artisan migrate

php artisan optimize

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the PHP-FPM server
php-fpm
