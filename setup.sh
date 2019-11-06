cp ./.env api/
docker-compose up -d
docker-compose exec api php bin/console doctrine:migrations:migrate -n

