FROM php:7.3.0-apache

ENV root /var/www/html/
WORKDIR $root

RUN apt-get update && \
apt-get -y upgrade && \
apt-get -y install git unzip nano

RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

COPY composer.* $root
RUN composer install --no-dev

COPY apache2.conf /etc/apache2/sites-enabled/000-default.conf
RUN docker-php-ext-install pdo_mysql

#COPY . $root

RUN chown -R www-data:www-data $root