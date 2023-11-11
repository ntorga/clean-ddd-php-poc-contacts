# PHP
FROM php:8.2.10-fpm
RUN apt-get update && apt-get install -y curl git
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
install-php-extensions opcache
RUN rm -f /usr/local/etc/php-fpm.d/www.conf
COPY /docker/www.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000