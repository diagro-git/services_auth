#!/usr/bin/env bash
/etc/wait-for-it.sh database:3306 -- echo "database is up"

composer install

php artisan migrate
php artisan db:seed

service nginx start
php-fpm
