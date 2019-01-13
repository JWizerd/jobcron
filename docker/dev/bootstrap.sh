#!/usr/local/bin/dumb-init /bin/sh
echo "export VERSION=$version" >> /etc/apache2/envvars
echo "export ENV=$env" >> /etc/apache2/envvars

echo "Launching Apache2 webserver...";
exec apache2-foreground
