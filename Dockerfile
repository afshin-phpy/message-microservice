FROM php:8.2-fpm

LABEL maintainer="Afshin"

WORKDIR /var/www/html

COPY . /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql

EXPOSE 9000

CMD php -S 0.0.0.0:9000 -t public