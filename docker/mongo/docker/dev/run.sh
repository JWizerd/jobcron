#!/bin/bash

# use local config if $service isn't present
if [[ -z $service ]]; then
  . ./config.sh
fi

echo "[*] creating persistent named volume for mongo : $volname"
docker volume create $volname > /dev/null 2>&1

echo "[*] creating docker network : $netname"
docker network create $netname > /dev/null 2>&1

echo "[*] running mongo server : name < $dbname > port [$dbport]"
docker rm -f $dbname > /dev/null 2>&1
docker run --name="$dbname" \
        --network=$netname \
        -v $volname:/data/db \
        -p $dbport:27017 \
        -d mongo:3.4.1
