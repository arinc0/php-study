FROM php:8.0-fpm-buster
SHELL ["/bin/bash","-oeux","pipefail","-c"]

RUN docker-php-ext-install pdo_mysql

COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www