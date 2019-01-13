#!/bin/bash

. ./config.sh

if [[ $# -lt 2 ]]; then
    echo "[!] usage: $0 [DB name] [backup tar.gz]"
    exit 1
fi

dbtoimport=$1
backuptar=$2

docker cp $backuptar $service:/tmp
docker exec -it $service tar -xvzf /tmp/$backuptar
docker exec -it $service mongorestore -d $dbtoimport /tmp/backup/"$dbtoimport"
