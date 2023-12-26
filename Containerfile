FROM docker.io/php:8.3-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y zip libzip-dev && \ 
    docker-php-ext-install zip

RUN a2enmod rewrite

COPY --from=docker.io/composer:2 /usr/bin/composer /usr/bin/composer

USER www-data

COPY --chown=www-data:www-data . .

RUN composer install --no-dev --optimize-autoloader

USER root