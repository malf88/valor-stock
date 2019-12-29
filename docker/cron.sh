#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

#if [ "$env" != "local" ]; then
#    echo "Caching configuration..."
#    (cd /var/www/maliin && php artisan config:cache && php artisan route:cache && php artisan view:cache)
#fi

if [ "$role" = "app" ]; then

    exec /usr/sbin/apache2ctl -D FOREGROUND


else
    echo "Could not match the container role \"$role\""
    exit 1
fi