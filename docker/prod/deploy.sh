#!/bin/bash

. ./config.sh

version=$((version+1))
echo $version > version.txt

echo "--- Deploying $service ::: ";

echo "Copying in source code and credentials...";
rsync -a ../../src .

echo "[*] generating the Dockerfile"
# this line will replace all instances of #SERVICENAME#
#  with the $service variable
sed "s/#SERVICENAME#/$service/g" Dockerfile.template > Dockerfile
if [[ ! -s ./Dockerfile ]]; then
    echo "ERROR: Dockerfile wasn't generated. Make sure that "
    echo " Dockerfile.template exists. Use #SERVICENAME# where"
    echo " you want $service to be filled in"
    echo "Exiting."
    rm Dockerfile
    exit 1
fi

echo "Building $service...";
docker build -t $service:$version .

echo "Cleaning up code...";
rm -rf aws.creds
rm -rf src

echo "[*] uploading to registry"
docker tag $service:$version $registry/$service:$version
docker push $registry/$service:$version

echo "Committing new version to git...";
git commit -m "Deploy version $version" version.txt

git pull --rebase
git push
echo "Deployed!";
