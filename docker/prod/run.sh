#!/bin/bash

. ./config.sh


echo "--- Running Production $service ::: ";
echo " -  version $version"

# run the database and network
. ../mongo/run.sh

echo "Running docker image $service:$version"
docker stop $service
docker rm -f $service
docker run --name="${service}Prod" \
    --network="$netname" \
    --log-opt max-size=25m \
    --log-opt max-file=4 \
    -c 5120 \
    -m 2g \
    -e "env=production" \
    -e "version=$version" \
    -e "dbname=$dbname" \
    -p $externalPort:80 \
    -d $service:$version
