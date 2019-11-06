#!/bin/bash

if [ $# -eq 0 ]
  then
    cp ./.env api/
    docker-compose up -d
    docker-compose exec api php bin/console doctrine:migrations:migrate -n
else
    if [[ $1 == --build ]]; then
        cp ./.env api/
    docker-compose up -d --build
    docker-compose exec api php bin/console doctrine:migrations:migrate -n
    else
        echo "Invalid argument. --build is the unique option you can add."
    fi
fi