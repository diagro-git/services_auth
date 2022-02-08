FROM php:8.0-fpm-buster

RUN apt-get update

RUN apt-get install -y nginx
COPY nginx/app.conf /etc/nginx/sites-enabled/default
COPY entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh

RUN apt install -y g++ libicu-dev libpq-dev libzip-dev zip zlib1g-dev curl git nano htop
RUN docker-php-ext-install intl opcache pdo pdo_mysql

RUN mkdir /diagro

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer

EXPOSE 5000

ENTRYPOINT ["/etc/entrypoint.sh"]
