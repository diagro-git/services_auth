#!/usr/bin/env bash
composer install

php artisan migrate --force
php artisan db:seed

service nginx start
php-fpm
