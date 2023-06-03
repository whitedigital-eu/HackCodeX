#!/usr/bin/env bash

ENVIRO=${1:-1}

ENVIROS=("dev" "stage" "prod")

NAME="termobloki_${ENVIRO}"

if [[ ! " ${ENVIROS[*]} " =~ ${ENVIRO} ]]; then
    echo "Allowed environments are: dev, stage, prod"
    exit
fi

CV=${2:-1}

cd ./docker/dev || exit

if [ "$CV" == "traefik" ]; then
    docker compose -f docker-compose.traefik.yml -p $NAME down
else
    docker compose -f docker-compose.yml -p $NAME down
fi
