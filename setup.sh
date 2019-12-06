#!/bin/bash

cp ./.env api/

if [ $# -eq 0 ]
  then
    docker-compose up -d
    cp ./.env api/
    docker-compose exec api php bin/console doctrine:migrations:migrate -n
else
    if [[ $1 == --build ]]; then
    docker-compose up -d --build
    cp ./.env api/
    docker-compose exec api php bin/console doctrine:migrations:migrate -n
    else
        echo "Invalid argument. --build is the unique option you can add."
    fi
fi
