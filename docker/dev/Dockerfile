FROM php:7.2-apache

#
# RUN
# 1. apt: install packages; clean pkg lists
# 2. install dumb-init
# 3. install the php mongodb extension
# 4. install composer and install packages
# 5. enable rewrite and headers apache modules
#

#
# ADD BASE INFRA FILES
#

# install custom php.ini
ADD php.ini /usr/local/etc/php/

# Link in the composer.json file
ADD composer.json /var/www/composer.json

# Install custom apache config
ADD apache2.conf /etc/apache2/apache2.conf

RUN apt-get update \
	&& apt-get install -y wget git libssl-dev zip unzip cron \
	&& rm -rf /var/lib/apt/lists/* \
	&& wget -O /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.0.3/dumb-init_1.0.3_amd64 \
	&& chmod +x /usr/local/bin/dumb-init \
	&& pecl install mongodb \
	&& docker-php-ext-enable mongodb \
	&& cd /var/www;curl -sS https://getcomposer.org/installer | php \
	&& cd /var/www;php composer.phar install \
	&& a2enmod rewrite headers

#
# ADD CRON FILES
#

# Add crontab file in the cron directory
ADD crontab /etc/cron.d/jobcron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/jobcron

# Apply cron job
RUN crontab /etc/cron.d/jobcron

# wire in a startup script
ADD bootstrap.sh /var/www/bootstrap.sh
CMD ["/var/www/bootstrap.sh"]
