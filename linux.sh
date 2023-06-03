#!/usr/bin/env bash

ENVIRO=${1:-1}

if [ "$ENVIRO" != "dev" ]; then
    echo "Only 'dev' environment currently available for start"
    exit
fi

NAME="hack_${ENVIRO}"

cd docker/dev || exit

docker compose -f docker-compose.linux.yml -p $NAME up -d --force-recreate

cd ../../src/api || exit

FRESH=${2:-1}

ENV_FILE=.env.local
ENV_FILE_TEST=.env.test.local

if [ "$FRESH" == "fresh" ]; then
    if [ ! -f "./$ENV_FILE" ]; then
        cp ../../.env.local.dist.traefik ${ENV_FILE}
    fi
    echo "APP_DEBUG=true" >> ${ENV_FILE}
    sed -i'' -e "s/_dev_/_${ENVIRO}_/g" ${ENV_FILE}

    if [ ! -f "./$ENV_FILE_TEST" ]; then
        cp ../../.env.test.local.dist.traefik ${ENV_FILE_TEST}
        sed -i'' -e "s/_dev_/_${ENVIRO}_/g" ${ENV_FILE_TEST}
    fi

    files=("var" "var/cache" "var/cache/dev" "var/cache/prod" "vendor" "public/bundles" "public/bundles/apiplatform")

    for i in "${files[@]}"; do
        if [[ ! -d $i ]]; then
            sudo mkdir -m 0777 "$i"
        fi

        set -- "$(stat --format '%a' "$i")"
        if [[ ! $2 == 777 ]]; then
            sudo chmod -R 777 "$i"
        fi
    done
fi

docker exec "${NAME}_php" rm -rf var/cache/*
docker exec "${NAME}_php" bash -c 'git config --global --add safe.directory "*"'
docker exec "${NAME}_php" composer install -n --ignore-platform-reqs
#docker exec "${NAME}_node" yarn

if [ "$FRESH" == "fresh" ]; then
    docker exec "${NAME}_php" bin/console doctrine:database:drop --force
    docker exec "${NAME}_php" bin/console doctrine:database:create
    docker exec "${NAME}_php" bin/console doctrine:migrations:migrate -n
    docker exec "${NAME}_php" bin/console doctrine:fixtures:load -n
fi

cd ../.. || exit
