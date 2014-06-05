#!/bin/bash

apt-get -y update

apt-get -y install vim php5 php5-curl apache2 make curl

ln -s /vagrant/vagrant/apache.conf /etc/apache2/sites-available/pr_viewer
a2ensite pr_viewer
a2dissite 000-default

service apache2 restart

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

cd /vagrant
composer install
