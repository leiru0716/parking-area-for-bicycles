create database parking default character set utf8;
use parking;
create table parking.parkings(id int primary key, latitude varchar(10), longitude varchar(10), genre varchar(10), name varchar(30), outline varchar(30), postalcode varchar(10), address varchar(50), phonenumber varchar(20), opentime varchar(30), closingday varchar(30), price varchar(100), remarks varchar(50), link varchar(50));
LOAD DATA LOCAL INFILE '~/media3syu/data.csv' INTO TABLE parkings FIELDS TERMINATED BY ',' ENCLOSED BY '"' lines terminated by '\n';

