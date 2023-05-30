#!/usr/bin/env bash
COMPOSE="docker-compose"
COMPOSE_BACKER="docker-compose exec backend"
COMPOSE_FRONTEND="docker-compose exec frontend"

if [ "$1" == "start" ]; then
    shift 1
    $COMPOSE up
# Stop all containers
elif [ "$1" == "stop" ]; then
    shift 1
    $COMPOSE stop
# Restart containers
elif [ "$1" == "restart" ]; then
    shift 1
    $COMPOSE stop && $COMPOSE up
# Run yii console commands
elif [ "$1" == "artisan" ]; then
    shift 1
    $COMPOSE_BACKER php artisan "$@"
# If "composer" is used, pass-thru to "composer"
# inside a new container
elif [ "$1" == "composer" ]; then
    shift 1
    $COMPOSE composer "$@"
# If "npm" is used, run npm
# from our node container
elif [ "$1" == "npm" ]; then
    shift 1
    $COMPOSE_FRONTEND npm "$@"
# Else, pass-thru args to docker-compose
else
    $COMPOSE "$@"
fi
