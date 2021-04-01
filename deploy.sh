#!/bin/bash

SITENAME="chekapps.com"
cd /var/www/$SITENAME/data/www/$SITENAME;

. ~/.bashrc

cd /var/www/$SITENAME/data/www/$SITENAME;
git pull;
composer install;
php artisan migrate;
NVM_DIR="$HOME/.nvm"
nvm use 12.14.1
yarn;
yarn production;
php artisan config:cache;
php artisan config:clear;
php artisan cache:clear;
php artisan route:cache;
php artisan view:cache;
