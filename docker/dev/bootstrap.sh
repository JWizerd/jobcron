#!/usr/local/bin/dumb-init /bin/sh
echo "export VERSION=$version" >> /etc/apache2/envvars
echo "export ENV=$env" >> /etc/apache2/envvars

echo "Launching Apache2 webserver...";

# To make sure custom classes are properly being autloaded
cd /var/www/ && php composer.phar dumpautoload -o;

echo "Launching the crontab....";
/usr/sbin/cron -f &
touch /var/www/html/cronErrors.txt
chmod 0777 /var/www/html/cronErrors.txt

exec apache2-foreground