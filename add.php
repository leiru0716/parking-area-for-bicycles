<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>phpチャット</title>
</head>
<body bgcolor="#ffffff">
<h1>場所追加ページ</h1>
<form name="add_place" method="POST" action="add.php">

id：<input type="text" size=10 name="id">
latitude：<input type="text" size=30 name="latitude">
longitude：<input type="text" size=30 name="longitude">
genre：<input type="text" size=30 name="genre">
name：<input type="text" size=30 name="name">
outline：<input type="text" size=30 name="outline">
postalcode：<input type="text" size=30 name="postalcode">
address：<input type="text" size=30 name="phonenumber">
phonenumber：<input type="text" size=30 name="opentime">
opentime：<input type="text" size=30 name="closingday">
closingday：<input type="text" size=30 name="price">
remarks：<input type="text" size=30 name="remarks">
link：<input type="text" size=30 name="link">

<input type="submit" value="送信"><br>
<?php

/* 投稿があった場合、データベースにデータを挿入 */

if(!empty($_POST['id'])){

  $dbh = new PDO('mysql:host=localhost;dbname=parking;charset=utf8;', 'root', '',array(PDO::ATTR_PERSISTENT => true));
  $sql = 'insert into parkings (id, latitude, longitude, genre, name, outline, postalcode, address, phonenumber, opentime, closingday, price, remarks, link) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )';
  $prep = $dbh->prepare($sql); // プリペアードステートメントとして扱う
  $result = $prep->execute(array($_POST['id'], $_POST['latitude'], $_POST['longitude'], $_POST['genre'], $_POST['name'], $_POST['outline'], $_POST['postalcode'], $_POST['address'], $_POST['phonenumber'], $_POST['opentime'], $_POST['closingday'], $_POST['price'], $_POST['remarks'], $_POST['link'])); // プリペアードステートメントは execute メソッドを使う。

  if(!$result){ // エラー処理
   print("データが保存できません:");
   die();
  }
}
?>
</form><hr>
</body>
</html>
