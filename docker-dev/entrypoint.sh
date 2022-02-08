#!/usr/bin/env bash
php artisan migrate --force
php artisan cache:clear

php artisan queue:work &

service nginx start
php-fpm
