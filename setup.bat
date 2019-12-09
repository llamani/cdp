@echo off
COPY .env .\api\.env

if "%~1" == "--build" (
    docker-compose up -d --build
    docker-compose exec api composer install
    goto migrations
) else (
    docker-compose up -d
    docker-compose exec api composer install
    goto migrations
)

:migrations
    COPY .env .\api\.env
    docker-compose exec api php bin/console doctrine:migrations:migrate -n
