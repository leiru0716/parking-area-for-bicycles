<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>phpチャット</title>
<script>
    // Geolocation APIに対応している
//    if (navigator.geolocation) {
//      alert("この端末では位置情報が取得できます");
    // Geolocation APIに対応していない
//    } else {
//      alert("この端末では位置情報が取得できません");
//    }

    // 現在地取得処理
    function getPosition() {
      // 現在地を取得
      navigator.geolocation.getCurrentPosition(
        // 取得成功した場合
        function(position) {
            	document.getElementById("lat").value = position.coords.latitude;
		document.getElementById("lon").value = position.coords.longitude;
		//alert("緯度:"+position.coords.latitude+",経度"+position.coords.longitude);
        },
        // 取得失敗した場合
        function(error) {
          switch(error.code) {
            case 1: //PERMISSION_DENIED
              alert("位置情報の利用が許可されていません");
              break;
            case 2: //POSITION_UNAVAILABLE
              alert("現在位置が取得できませんでした");
              break;
            case 3: //TIMEOUT
              alert("タイムアウトになりました");
              break;
            default:
              alert("その他のエラー(エラーコード:"+error.code+")");
              break;
          }
        }
      );
    }
  </script>

</head>
<body bgcolor="#ffffff">
<h1>場所追加ページ</h1>
<form name="add_place" method="POST" action="add.php">

id：<input type="text" size=10 name="id"><br>
緯度：<input type="text" size=30 name="latitude"><br>
経尾：<input type="text" size=30 name="longitude"><br>
ジャンル：<input type="text" size=30 name="genre"><br>
名称：<input type="text" size=30 name="name"><br>
概略：<input type="text" size=30 name="outline"><br>
郵便番号：<input type="text" size=30 name="postalcode"><br>
住所：<input type="text" size=30 name="phonenumber"><br>
電話番号：<input type="text" size=30 name="opentime"><br>
開館時間：<input type="text" size=30 name="closingday"><br>
休館時間：<input type="text" size=30 name="price"><br>
備考：<input type="text" size=30 name="remarks"><br>
リンク：<input type="text" size=30 name="link"><br>

<input type="submit" value="送信"><br><br>
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

<br>
<!--フォームの中で位置情報が取得できなかったんで、泣く泣くここに位置情報を取得するボタンを配置しました-->
<button onclick="getPosition();">位置情報を取得する</button>
<br>
現在の緯度：<input id="lat">
<br>
現在の経度：<input id="lon">
</body>
</html>
