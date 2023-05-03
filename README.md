#AppBase
##ToDos


##Take care

1. Always Sync .env and .env example, to be clear whenever you add an .env variable add a similar key to .env.example


####How to run docker container:

Execute this commands at root level of project:

    docker-compose build --no-cache (execute only at first run)
    docker-compose up (on first run it installs dependencies and requires time)

####How to migrate database and fetch initial data

Docker container should be running

    docker-compose exec app php artisan migrate:fresh
    docker-compose exec app php artisan fetch:countries
    docker-compose exec app php artisan fetch:countries:stats

####How to stop:

    docker-compose -f docker-compose.local.yml down

####Services:

API service will be available at http://127.0.0.1:8001/api

MySQL service will be available at

    host: mysql
    port: 3306
    database: laravel
    username: laravel
    password: secret

####Testing:

Docker should be running

    docker-compose exec app php artisan test
