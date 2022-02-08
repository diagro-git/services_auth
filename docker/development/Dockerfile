FROM php:8.0-fpm-buster

RUN apt-get update
RUN apt install -y g++ libicu-dev libpq-dev libzip-dev zip zlib1g-dev curl
RUN docker-php-ext-install intl opcache pdo pdo_mysql

RUN apt-get install -y nginx
COPY docker/development/nginx/app.conf /etc/nginx/sites-enabled/default
COPY docker/development/entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer

RUN mkdir /diagro
WORKDIR /diagro
EXPOSE 80 443
ENTRYPOINT ["/etc/entrypoint.sh"]