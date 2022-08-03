# Lumen PHP Microservice

[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

This microservice is meant to register and authenticate users through API. All interaction is through APIs and it uses RestFull API.

## Setup
git clone
compsoer install
cp .env.example .env ~ setup all setting i.e DB etc

## Testing
run php -S localhost:8004 -t public in local folder and use Postman or something similar to make calls to register and login endpoints below

## Unit test
If you want to run unit tests outside the docker container, you can user
docker exec -it app ./vendor/bin/phpunit else log into the container and run  ./vendor/bin/phpunit.

All tests are using the DatabaseTransactions trait so that changes get rolled back after the test as this is using the main database.

