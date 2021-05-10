#!/bin/bash
composer install
composer dump-autoload
npm install -D
./vendor/bin/phpunit --testdox Tests
mkdir /var/www/html/uploads
php7.4 -S 0.0.0.0:8000 -t public/
