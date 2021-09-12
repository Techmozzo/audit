#!/bin/bash
# Set permissions to storage and bootstrap cache
sudo chmod -R 0777 /var/www/html/storage
sudo chmod -R 0777 /var/www/html/bootstrap/cache
#
cd /var/www/html
#
# Run composer
#sudo /usr/bin/composer.phar install --no-ansi --no-dev --no-suggest --no-inter
curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/local/bin --filename=composer
composer install --no-script

#
# Run artisan commands
#php /var/www/html/artisan migrate permissions
#cd /var/www/html/

#Start up docker
sudo docker-compose up

#Enter docker execution shell
sudo docker-compose exec audit sh

#migrate
php artisan migrate -f


