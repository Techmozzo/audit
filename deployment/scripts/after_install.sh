#!/bin/bash
# Set permissions to storage and bootstrap cache
sudo chmod -R 0777 /var/www/html/storage
sudo chmod -R 0777 /var/www/html/bootstrap/cache
#
cd /var/www/html
#

# Run composer  when no using docker-compose.yaml

composer install

#/usr/bin/composer.phar install --no-script

#
# Run artisan commands
#php /var/www/html/artisan migrate permissions
#cd /var/www/html/

#Start up docker
# sudo docker-compose up

#Enter docker execution shell
# sudo docker-compose exec audit sh

#migrate
php artisan migrate --force

#serve the application when no using docker-compose.yaml

php artisan serve --host=0.0.0.0
