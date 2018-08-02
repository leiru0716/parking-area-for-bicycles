#!/bin/bash

cp my.cnf /etc
mysql -u root < sql.sql
cp index.php /var/www/html
cp update.php /var/www/html
cp add.php /var/www/html
cp delete.php /var/www/html
cp MapApi.js /var/www/html

firefox localhost &
exit 0
