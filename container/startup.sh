#!/bin/sh

echo "Starting container setup..."
php artisan migrate:refresh --seed
php artisan serve --host=0.0.0.0 --port=8000