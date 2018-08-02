# 三衆のプロジェクトです    
ホームディレクトリでgit cloneしてください  



## クローンしたらやること  

	### クイックセットアップ  
		quicksetup.sh を実行する  
	

	### クイックセットアップでダメだったら  
	- データベースの文字コードをutf-8に変更する  
		my.cnfを/etcの場所に上書きしてください  

	- プログラムファイル移動  
    		index.php add.php update.php delete.php MapApi.js を/var/www/htmlにコピーする  


	- MariaDBにログインした後下記コマンドを打つ   

			create database parking default character set utf8;
			use parking;
			create table parking.parkings(id int primary key, latitude varchar(10), longitude varchar(10), genre varchar(10), name varchar(30), outline varchar(30), postalcode varchar(10), address varchar(50), phonenumber varchar(20), opentime varchar(30), closingday varchar(30), price varchar(100), remarks varchar(50), link varchar(50));
			LOAD DATA LOCAL INFILE '~/media3syu/data.csv' INTO TABLE parkings FIELDS TERMINATED BY ',' ENCLOSED BY '"' lines terminated by '\n';



## HOW TO USE IT  


- localhost または localhost/index.phpにアクセスする  
- googlemap上のピンをクリックすれば、その場所の詳細が表示されます。  
- 郵便番号検索では***-****の形式で入力すれば、それに合致した場所が表示されます
- リセットボタンで非表示になっていたピンが全表示されます  
-
- 場所追加ページでは場所の追加ができます。追加する時はidと緯度と経度を必ず埋めてください。位置情報を取得ボタンを押すと現在位置の緯度と経度が取得できます  
- 場所変更ページでは場所の詳細情報の変更ができます。必ず存在してあるidを指定してください。入力値のバリデーションを行ってないので、存在してあるidを指定しさえすれば、他の項目を入力していなくても追加されます  
- 場所削除ページではidを指定して場所の削除ができます。  

###	データベースの構造

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
 
### 制約条件  

- PCでの位置情報はセキュリティの都合上HTTPでは使用できないため、利用する場合は必ずHTTPSで接続しなければならない  
- VM上ではなくホスト側からアクセスすると、現在位置が取得できない。 必ずセットアップしたマシン上でアクセスすること  














