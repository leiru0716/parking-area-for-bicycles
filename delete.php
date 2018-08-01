<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>phpチャット</title>
<script>
  </script>

</head>
<body bgcolor="#ffffff">
<h1>場所削除ページ</h1>
<form name="add_place" method="POST" action="delete.php">
削除したいIDを入力<br>
id：<input type="text" size=10 name="id"><br>

<input type="submit" value="送信"><br><br>
<?php

/* 投稿があった場合、データベースにデータを挿入 */

if(!empty($_POST['id'])){

  $dbh = new PDO('mysql:host=localhost;dbname=parking;charset=utf8;', 'root', '',array(PDO::ATTR_PERSISTENT => true));
  $sql = 'delete from parkings where id = ?';
  $prep = $dbh->prepare($sql); // プリペアードステートメントとして扱う
  $result = $prep->execute(array($_POST['id'])); // プリペアードステートメントは execute メソッドを使う。

  if(!$result){ // エラー処理
   print("データが削除できません:");
   die();
  }
}
?>
</form><hr>

<br>
</body>
</html>
