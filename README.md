#AppBase
##ToDos


##Take care

1. Always Sync .env and .env example, to be clear whenever you add an .env variable add a similar key to .env.example

##Features
1. Docker

####How to run docker container:

Execute this commands at root level of project:

    docker-compose -f docker-compose.local.yml build --no-cache (execute only at first run)
    docker-compose -f docker-compose.local.yml up (on first run it installs dependencies and requires time)

####How to migrate database and fetch initial data

Docker container should be running

    docker-compose -f docker-compose.local.yml exec app php artisan migrate:fresh
    docker-compose -f docker-compose.local.yml exec app php artisan fetch:countries
    docker-compose -f docker-compose.local.yml exec app php artisan fetch:countries:stats

####How to stop:

    docker-compose -f docker-compose.local.yml down

####Services:

API service will be available at http://127.0.0.1:8001

MySQL service will be available at

    host: mysql
    port: 3306
    database: laravel
    username: laravel
    password: secret

