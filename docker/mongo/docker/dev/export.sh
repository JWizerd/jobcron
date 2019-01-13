#!/bin/bash

. ./config.sh

if [[ $# -lt 1 ]]; then
    echo "[!] usage: $0 [DB name]"
    echo " - name of mongodb db, not container"
    exit 1
fi

dbtoback=$1

docker exec -it $service mongodump -d $dbtoback -o /tmp/backup
docker exec -it $service tar -czvf /tmp/mongo_back-"$dbtoback"-"$(date +%m-%d-%y)".tar.gz /tmp/backup
docker cp $service:/tmp/mongo_back-"$dbtoback"-"$(date +%m-%d-%y)".tar.gz .
