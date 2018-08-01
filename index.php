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




// ex. 
// test[0][0] 
// = {0: "1414", 1: "36.5806", 2: "136.648722", 3: "駐車場・駐輪場", 4: "駐車場", 5: "", 6: "", 7: "", 8: "", 9: "金沢駅西口時計駐車場", 10: "収容台数：1500台", 11: "920-0031", 12: "金沢市広岡1-401", 13: "076-263-5151", id: "1414", latitude: "36.5806", longitude: "136.648722", genre: "駐車場・駐輪場", name: "駐車場", …}
// test[0][0][2] 
// = "136.648722"
var test=JSON.parse('<?php echo  $json_data; ?>');

var map;
var marker=[];
var infoWindow=[];


var ms_ll;
var timer;
var destinationMarker;
function initMap() {
	var DS = new google.maps.DirectionsService();
	var DR = new google.maps.DirectionsRenderer();

	map = new google.maps.Map(document.getElementById('parkingmap'), { // #sampleに地図を埋め込む
        center: { // 地図の中心を指定
            lat: 36.530612, // 緯度
            lng: 136.627774 // 経度
        },
        zoom: 12 // 地図のズームを指定
	});
	/* map を DirectionsRendererオブジェクトのsetMap()を使って関連付け */
    DR.setMap(map);

    map.addListener("mousedown",function(e){
        timer=new Date().getTime();
        ms_ll=e.latLng;
        
    });
    map.addListener("mouseup",function(e){
        if(timer){
            var ms_ll_dist=getDistance(ms_ll.lat(),
                    ms_ll.lng(),
                    e.latLng.lat(),
                    e.latLng.lng());
           if((new Date().getTime()-timer)>500 && ms_ll_dist.distance==0){
                 destinationMarker.setVisible(!destinationMarker.getVisible());
           }
        }
    });


    // マーカー毎の処理
    for (var i = 0; i < test.length; i++) {
        markerLatLng = new google.maps.LatLng({lat: Number(test[i][0]['latitude']), lng: Number(test[i][0]['longitude'])}); // 緯度経度のデータ作成
        marker[i] = new google.maps.Marker({ // マーカーの追加
            position: markerLatLng, // マーカーを立てる位置を指定
            map: map // マーカーを立てる地図を指定
        });

        infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
            content: '<div class="parkingmap">' + 'id:' + test[i][0][0] + '<br>'+ 'lat:' + test[i][0][1] + '<br>' + 'lon:' + test[i][0][2] + '<br>'  + test[i][0][3] + '<br>' + test[i][0][4] + '<br>' + test[i][0][5] + '<br>' + test[i][0][6] + '<br>' + test[i][0][7] + '<br>' + test[i][0][8] + '<br>' + test[i][0][9] + '<br>' + test[i][0][10] + '<br>' + test[i][0][11] + '<br>' + test[i][0][12] + '<br>' + test[i][0][13] + '</div>' // 吹き出しに表示する内容
        });

        markerEvent(i); // マーカーにクリックイベントを追加
    }

    document.getElementById("btn").onclick = function() {
        /* 開始地点と目的地点、ルーティングの種類を設定 */
        var from = new google.maps.LatLng( document.getElementById('lat').value, document.getElementById('lon').value );
        var to = new google.maps.LatLng( document.getElementById('lat2').value, document.getElementById('lon2').value  );

        var latlngs=Marker2LatLng(marker);
        Nearest(to,latlngs)
        .then(function(result){
            console.log(result);
            var request = {
                origin: from,
                destination: to,
                waypoints: [{location: result[0].latlng}],
                travelMode: google.maps.TravelMode.WALKING
            };
            DS.route(request, function(result, status) {
                DR.setDirections(result);
            });
        },function(e){
            console.log('error'+e);
        });
    }
    

    var destinationMarker=new google.maps.Marker({
        position:new google.maps.LatLng(36.530612,136.627774),
        title:"current position",
        draggable:true,
        animation: google.maps.Animation.DROP,
	    label: {
		    text: '目的',                          
		    color: '#FFFFFF',                    
		    fontSize: '11px'                     
        },
        zIndex: 500
    });
    destinationMarker.setMap(map);
    var cpos_iw=new google.maps.InfoWindow({
        content: "現在位置"
    });
    destinationMarker.addListener('dragend', function(e){
        console.log("dragend")
        if(destinationMarker.getVisible()){
		    document.getElementById('lat2').value = e.latLng.lat();
            document.getElementById('lon2').value = e.latLng.lng();
        }
	});
    destinationMarker.setVisible(false);



}
function adddraggableMarker(){

}
// マーカーにクリックイベントを追加
function markerEvent(i) {
    marker[i].addListener('click', function() { // マーカーをクリックしたとき
        for(var j=0;j<infoWindow.length;j++) infoWindow[j].close();//全てのふきだしを非表示に
      infoWindow[i].open(map, marker[i]); // 吹き出しの表示
  });
}

function searchPcode() {
	for(var i = 0;i <test.length;i++){
        var pcode=document.getElementById('pcode').value;
        if(pcode.search(/\b...-\b..../)!=-1){
            if(test[i][0]['postalcode']== pcode){
                marker[i].setVisible(true);
            }
            else{
                marker[i].setVisible(false);
            }
        }
    }
    searchOutline();
    searchHours();
}

function resetPcode() {
    for(var i = 0;i <test.length;i++){
        marker[i].setVisible(true);
    } 
}
function searchOutline(){
    var val=document.getElementById('vtype').selectedIndex;
    var vtype=document.getElementById('vtype').options[val].value;
    var uppernum=document.getElementById('park_num').value;
    var regex=new RegExp(vtype+"\\d+");
    for(var i=0;i<test.length;i++){
        if(marker[i].getVisible()){

            var m_result=test[i][0]['outline'].match(regex);
            if(m_result){
                var num=m_result[0].match(/\d+/g);
                if(Number(num[0])<uppernum){
                    marker[i].setVisible(false);
                }
            }else{
                marker[i].setVisible(false);
            }

        }

    }
}
function searchHours(){
    var hours=document.getElementById('time').value;
    for(var i=0;i<test.length;i++){
        if(marker[i].getVisible()){
            if(test[i][0]['opentime']!='終日'){
                var split_time=test[i][0]['opentime'].split('〜');
                var open=split_time[0].replace(/:/g,'');
                var close=split_time[1].replace(/:/g,'');
                var check=hours.replace(/:/g,'');
                if(Number(open)>Number(check) || Number(check)>Number(close)){
                    marker[i].setVisible(false);
                }
            }
        }
    }
}


</script>

<select id="vtype">
<option value="自転車">自転車</option>
<option value="原付">原付</option>
</select>
<input id="park_num" type="number" value="0">台以上
<br>
<input type="time" id="time" />に営業中
<br>
<input id="pcode">
<br>
<button onclick="searchPcode();">郵便番号で検索</button>
<button onclick="resetPcode();">リセット</button>
<br>
<div id="parkingmap" style="width:700px;height:400px;">

</div>
<br>
<!--フォームの中で位置情報が取得できなかったんで、泣く泣くここに位置情報を取得するボタンを配置しました-->
<button onclick="getPosition();">位置情報を取得する</button>
<br>
現在の緯度：<input id="lat">
<br>
現在の経度：<input id="lon">
<br>
<br>
目的の緯度：<input id="lat2">
<br>
目的の経度：<input id="lon2">
<br><input type="button" id="btn" value="ルートを表示">



<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_cGsCdN3cJtnVFoOpOAvl6JV0iXaB96U&callback=initMap">
</script>
<script type="text/javascript" src="MapApi.js"></script>