#!/bin/bash

SITENAME="chekapps.com"
cd /var/www/$SITENAME/data/www/$SITENAME;

. ~/.bashrc

cd /var/www/$SITENAME/data/www/$SITENAME;
git pull;
composer install;
php artisan migrate;
php artisan config:cache;
php artisan route:cache;
php artisan view:cache;
yarn;
yarn production;
