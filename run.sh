#!/bin/bash

#remove duplicate container if it exists
docker rm -f jobcron

docker run --name="jobcron" \
    -p 3001:80 \
    -v $(pwd):/var/www/html/ \
    -d jobcron