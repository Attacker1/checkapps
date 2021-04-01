#!/bin/bash

SITENAME="chekapps.com"
cd /var/www/$SITENAME/data/www/$SITENAME;

. ~/.bashrc

cd /var/www/$SITENAME/data/www/$SITENAME;
git pull;
composer install --ignore-platform-reqs=php;
php artisan migrate;
php artisan config:cache;
php artisan route:cache;
php artisan view:cache;
NVM_DIR="$HOME/.nvm"
nvm use 12.14.1
yarn;
yarn production;
