<a href="add.php">場所追加ページ</a><br>
<a href="update.php">場所変更ページ</a><br>
<a href="delete.php">場所削除ページ</a><br>

<?php

$data = array();

try {
	$dbh = new PDO('mysql:host=localhost;dbname=parking;charset=utf8;', 'root', '',array(PDO::ATTR_PERSISTENT => true));
	        foreach($dbh->query('SELECT * from parkings') as $row) {
			#     print_r($json_data = json_encode($row,JSON_UNESCAPED_UNICODE));
			$data[] = array($row);
				    }
	        $dbh = null;
} catch (PDOException $e) {
	    print "エラー!: " . $e->getMessage() . "<br/>";
	        die();
}

$json_data = json_encode($data,JSON_UNESCAPED_UNICODE);

//var_dump($json_data);
?>

<script>
// ex. 
// test[0][0] 
// = {0: "1414", 1: "36.5806", 2: "136.648722", 3: "駐車場・駐輪場", 4: "駐車場", 5: "", 6: "", 7: "", 8: "", 9: "金沢駅西口時計駐車場", 10: "収容台数：1500台", 11: "920-0031", 12: "金沢市広岡1-401", 13: "076-263-5151", id: "1414", latitude: "36.5806", longitude: "136.648722", genre: "駐車場・駐輪場", name: "駐車場", …}
// test[0][0][2] 
// = "136.648722"
var test=JSON.parse('<?php echo  $json_data; ?>');

var map;
var marker=[];
var infoWindow=[];
function initMap() {
    map = new google.maps.Map(document.getElementById('parkingmap'), { // #sampleに地図を埋め込む
        center: { // 地図の中心を指定
            lat: 36.530612, // 緯度
            lng: 136.627774 // 経度
        },
        zoom: 15 // 地図のズームを指定
    });

    // マーカー毎の処理
 for (var i = 0; i < test.length; i++) {
        markerLatLng = new google.maps.LatLng({lat: Number(test[i][0]['latitude']), lng: Number(test[i][0]['longitude'])}); // 緯度経度のデータ作成
        marker[i] = new google.maps.Marker({ // マーカーの追加
         position: markerLatLng, // マーカーを立てる位置を指定
            map: map // マーカーを立てる地図を指定
       });
 
     infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
         content: '<div class="parkingmap">' + 'id:' + test[i][0][0] + '<br>' + test[i][0][3] + '<br>' + test[i][0][4] + '<br>' + test[i][0][5] + '<br>' + test[i][0][6] + '<br>' + test[i][0][7] + '<br>' + test[i][0][8] + '<br>' + test[i][0][9] + '<br>' + test[i][0][10] + '<br>' + test[i][0][11] + '<br>' + test[i][0][12] + '<br>' + test[i][0][13] + '</div>' // 吹き出しに表示する内容
       });
 
     markerEvent(i); // マーカーにクリックイベントを追加
 }
 
}
// マーカーにクリックイベントを追加
function markerEvent(i) {
    marker[i].addListener('click', function() { // マーカーをクリックしたとき
      infoWindow[i].open(map, marker[i]); // 吹き出しの表示
  });
}

</script>

<div id="parkingmap" style="width:700px;height:400px;">

</div>


<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBYLx1uVla1Ttt19Jp-k35yo8DoDB-DCI&callback=initMap">
</script>





