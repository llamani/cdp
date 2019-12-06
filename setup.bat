@echo off
COPY .env .\api\.env

if "%~1" == "--build" (
    docker-compose up -d --build
    goto migrations
) else (
    docker-compose up -d
    goto migrations
)

:migrations
    COPY .env .\api\.env
    docker-compose exec api php bin/console doctrine:migrations:migrate -n
