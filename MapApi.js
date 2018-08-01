function RouteSearch(map,basepos,nearest){


 
    var directionsService = new google.maps.DirectionsService();


    directionsService.route({
        origin: basepos, // スタート地点
        destination: nearest[0].latlng, // ゴール地点
        travelMode: google.maps.DirectionsTravelMode.WALKING, // 移動手段
    },function(response,status){
        if (status === google.maps.DirectionsStatus.OK) {
            new google.maps.DirectionsRenderer({
                map: map,
                directions: response,
                suppressMarkers: true // デフォルトのマーカーを削除
            });
            let leg = response.routes[0].legs[0];
            //makeMarker(leg.end_location, markers.goalMarker, map);
            setTimeout(function() {
                map.setZoom(16); // ルート表示後にズーム率を変更
            });
        }
    });
}
function Nearest(basepos,latlngs){
    //直線距離順が最寄とは限らないのでgetDistanceMatrixで道順を考慮した距離と到着時間を計算
    var service=new google.maps.DistanceMatrixService;
    
    //目的地種類が25個までなので単純直線で最も近いtop25を計算
    var top25=[];
    for(var i=0;i<latlngs.length;i++){
        top25.push({"number":i,
        
            "distance":
            getDistance(basepos.lat(),basepos.lng(),
            latlngs[i].lat(),
            latlngs[i].lng()).distance,

            "latlng":latlngs[i]
        });
    }
    top25.sort(function(a,b){
        if(a.distance<b.distance) return -1;
        if(a.distance>b.distance) return 1;
        return 0;
    });
   
    var latlngs_alt=[];
    for(var i=0;i<25 && i<top25.length;i++){
        latlngs_alt.push(top25[i].latlng);
    }

    var result_data=[];
    return new Promise(function(resolve,reject){
        service.getDistanceMatrix({
            origins:[basepos],
            destinations:latlngs.slice(0,24),
            travelMode:'WALKING',
        },function(response,status){
            if(status!=='OK'){
                console.log('ERROR:'+status);
                reject(status);
                
            }else if(status=='OK'){
                var results = response.rows[0].elements;
                for (var j = 0; j < results.length; j++) {
                    var element = results[j];
                    var distance = element.distance;
                    var duration = element.duration;
                    result_data.push({
                        "latlng": latlngs_alt[j],
                        "distance": distance,
                        "duration": duration
                    });
                }
                // result_data.sort(function(a,b){
                //     if(a.distance.value>b.distance.value) return -1;
                //     if(a.distance.value<b.distance.value) return 1;
                //     return 0;
                // });
                
                resolve(result_data);
            }else{
                reject(status);
            }
        });
    });
}
function Marker2LatLng(marker){
    var pointLatLng=[];
    for(var i=0;i<marker.length;i++){
        if(marker[i].getVisible())
            pointLatLng.push(marker[i].getPosition());

    }
    console.log(pointLatLng.length);
    return pointLatLng;
}
function LocateCurrentPos(){
    navigator.geolocation.getCurrentPosition(
        function(position){
            var pos=new google.maps.LatLng(
                position.coords.latitude,
                position.coords.longitude);
            return pos;
        },
        function(error){
            switch(error.code){
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
    )

}

function getDistance(lat1, lng1, lat2, lng2) {
    var lat1 = (+lat1),
    lng1 = (+lng1),
    lat2 = (+lat2),
    lng2 = (+lng2),
    lat_average = Math.PI / 180 * ( lat1 + ((lat2 - lat1) / 2) ),
    lat_difference = Math.PI / 180 * ( lat1 - lat2 ),
    lon_difference = Math.PI / 180 * ( lng1 - lng2 ),
    curvature_radius_tmp = 1 - 0.00669438 * Math.pow(Math.sin(lat_average), 2),
    meridian_curvature_radius = 6335439.327 / Math.sqrt(Math.pow(curvature_radius_tmp, 3)),
    prime_vertical_circle_curvature_radius = 6378137 / Math.sqrt(curvature_radius_tmp),
    distance = 0,
    distance_unit = "";
    //２点間の距離をメートルで取得する（単位なし）
    distance = Math.pow(meridian_curvature_radius * lat_difference, 2) + Math.pow(prime_vertical_circle_curvature_radius * Math.cos(lat_average) * lon_difference, 2);
    distance = Math.sqrt(distance);
    distance = Math.round(distance);
    // ２点間の距離を単位ありで取得する（1000m以上は、kmで表示）
    distance_unit = Math.round(distance);
    if (distance_unit < 1000) {
        distance_unit = distance_unit + "m";
    } else {
        distance_unit = Math.round(distance_unit / 100);
        distance_unit = (distance_unit / 10) + "km";
    }
    return {
        "distance": distance,
        "distance_unit": distance_unit
    };
}