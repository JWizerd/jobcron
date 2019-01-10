FROM php:7.2-apache

ENV root /var/www/html/
WORKDIR $root

RUN apt-get update && \
    apt-get -y upgrade && \
    apt-get -y install git unzip nano && \
    docker-php-ext-install bcmath pdo_mysql && \
    curl -s https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

ADD source $root
ADD apache2.conf /etc/apache2/sites-enabled/000-default.conf

ADD bootstrap.sh /root/bootstrap.sh
CMD ["/root/bootstrap.sh"]
