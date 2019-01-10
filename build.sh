#!/bin/bash

mkdir docker/source
bindfs -n source/core docker/source

docker build -t jobcron docker

fusermount -u docker/source
rmdir docker/source
