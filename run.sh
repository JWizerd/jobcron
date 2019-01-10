#!/bin/bash

echo "Creating local network"
docker network create local-net

docker rm -f jobcron

docker run --name="jobcron" \
    -p 30011:80 \
    -v $PWD/source/core/:/var/www/html/ \
    --network='local-net' \
    -d jobcron
