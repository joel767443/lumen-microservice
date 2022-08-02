#!/bin/sh
docker-compose exec -T app php artisan migrate:fresh --force
