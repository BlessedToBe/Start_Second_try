#!/bin/sh
set -e

role=${CONTAINER_ROLE:-app}

if [ "$role" = "queue" ]; then
    echo "Running the queue..."
    php /var/www/app/artisan queue:work --verbose --tries=3 --timeout=90

elif [ "$role" = "scheduler" ]; then
    echo "Running the scheduler..."
    while [ true ]
    do
      php /var/www/app/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done
elif [ "$role" = "app" ]; then

    echo "Running the php-fpm..."
    php-fpm
fi

