#!/bin/bash

#remove duplicate container if it exists
docker rm -f recipes

docker run --name="recipes" \
    -p 3001:80 \
    -v $(pwd):/var/www/html/ \
    -d recipes