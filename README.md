三衆のプロジェクトです  




- クローンしたらやること  
	- データベースの文字コードをutf-8に変更する  
		my.cnfを/etcの場所に上書きしてください  

    - index.php add.php update.php delete.php MapApi.js を/var/www/htmlにコピーする  


	- MariaDBにログインした後下記コマンドを打つ   

			create database parking default character set utf8;
			use parking;
			create table parking.parkings(id int primary key, latitude varchar(10), longitude varchar(10), genre varchar(10), name varchar(30), outline varchar(30), postalcode varchar(10), address varchar(50), phonenumber varchar(20), opentime varchar(30), closingday varchar(30), price varchar(100), remarks varchar(50), link varchar(50));
			LOAD DATA LOCAL INFILE '~/media3syu/data.csv' INTO TABLE parkings FIELDS TERMINATED BY ',' ENCLOSED BY '"' lines terminated by '\n';


	データベースの構造は以下の通り

| Field       | Type         | Null | Key | Default | Extra |
|-------------|--------------|------|-----|---------|-------|
| id          | int(11)      | NO   | PRI | NULL    |       |
| latitude    | varchar(10)  | YES  |     | NULL    |       |
| longitude   | varchar(10)  | YES  |     | NULL    |       |
| genre       | varchar(10)  | YES  |     | NULL    |       |
| name        | varchar(30)  | YES  |     | NULL    |       |
| outline     | varchar(30)  | YES  |     | NULL    |       |
| postalcode  | varchar(10)  | YES  |     | NULL    |       |
| address     | varchar(50)  | YES  |     | NULL    |       |
| phonenumber | varchar(20)  | YES  |     | NULL    |       |
| opentime    | varchar(30)  | YES  |     | NULL    |       |
| closingday  | varchar(30)  | YES  |     | NULL    |       |
| price       | varchar(100) | YES  |     | NULL    |       |
| remarks     | varchar(50)  | YES  |     | NULL    |       |
| link        | varchar(50)  | YES  |     | NULL    |       |
 
 
PCでの位置情報はセキュリティの都合上HTTPでは使用できないため、利用する場合は必ずHTTPSで接続しなければならない













