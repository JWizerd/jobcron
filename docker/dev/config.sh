#!/bin/bash

service=jobcron

externalPort=63501
appPort=80

dbname=$service-mongo
dbport=27017

# don't change these
volname=$service-vol
netname=$service-net

registry=*jwizerd*
