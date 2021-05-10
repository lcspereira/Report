#!/bin/bash
composer install
composer dump-autoload
./vendor/bin/phpunit --testdox Tests
php7.4 -S 0.0.0.0:8000 -t public/
