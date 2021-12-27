#!/bin/bash

docker-compose build
docker compose up -d

docker compose exec php /bin/bash -c "
cp .env.example .env;
chmod 666 .env;

composer install;
php artisan key:generate;
php artisan storage:link;
chmod -R 777 storage bootstrap/cache;

php artisan migrate;
"