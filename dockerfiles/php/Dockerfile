# Author: Guilherme Bach
# 2020-03-14
# v1.0

FROM php:8.0.3
WORKDIR /var/www/html/
RUN apt-get update \
 && docker-php-ext-install mysqli pdo pdo_mysql
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer