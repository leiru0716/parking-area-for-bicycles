<template>
  <div>
    <div
      id="map"
      :style="{width: mapWidth + 'px',height: mapHeight + 'px'}"/>
  </div>
</template>

<script>
var scriptjs = require('scriptjs')

export default {
  name: 'Gmap',
  props: {
    mapWidth: {
      type: Number,
      default: 100
    },
    mapHeight: {
      type: Number,
      default: 100
    },
    lat: {
      type: Number,
      default: 34.722677
    },
    lng: {
      type: Number,
      default: 135.492364
    },
    zoom: {
      type: Number,
      default: 8
    },
    markers: {
      type: Array,
      default: () => {
        return []
      }
    }
  },
  data () {
    return {
      map: null,
      formattedMarkers: []
    }
  },
  watch: {
    markers () {
      // マーカーを全削除
      this.formattedMarkers.forEach(marker => {
        marker.setMap(null)
      })
      // propsからも削除
      this.formattedMarkers.splice(0, this.formattedMarkers.length)

      // 再描画
      this.addMarker()
    }
  },
  created () {
    scriptjs(
      'https://maps.googleapis.com/maps/api/js?key=AIzaSyCM-AMmwI8j_7n0uQXjKSgpQK-_Rdj3iGw&callback=initMap',
      'loadGoogleMap'
    )
    scriptjs.ready('loadGoogleMap', this.loadMap)
  },
  mounted () {},
  methods: {
    addMarker () {
      this.markers.forEach(markerInfo => {
        var contentString =
          '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>' +
          '<h1 id="firstHeading" class="firstHeading">Uluru</h1>' +
          '<div id="bodyContent">' +
          '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
          'sandstone rock formation in the southern part of the ' +
          'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) ' +
          'south west of the nearest large town, Alice Springs; 450&#160;km ' +
          '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major ' +
          'features of the Uluru - Kata Tjuta National Park. Uluru is ' +
          'sacred to the Pitjantjatjara and Yankunytjatjara, the ' +
          'Aboriginal people of the area. It has many springs, waterholes, ' +
          'rock caves and ancient paintings. Uluru is listed as a World ' +
          'Heritage Site.</p>' +
          '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
          'https://en.wikipedia.org/w/index.php?title=Uluru</a> ' +
          '(last visited June 22, 2009).</p>' +
          '</div>' +
          '</div>'

        // マーカー
        let marker = new google.maps.Marker({
          position: markerInfo.position,
          icon:
            'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
          map: this.map,
          // ポップなアニメーションを付与
          animation: google.maps.Animation.DROP
        })

        // マーカーのwindow
        let infowindow = new google.maps.InfoWindow({
          content: contentString
        })

        // マーカークリック時にwindow表示
        marker.addListener('click', function () {
          infowindow.open(this.map, marker)
        })
        this.formattedMarkers.push(marker)
      })
    },
    loadMap () {
      console.log('loadMap')
      // googleMapを初期化
      this.map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: this.lat, lng: this.lng },
        zoom: this.zoom,
        // スワイプ判定を強めに設定(地図を移動させるには..問題)
        gestureHandling: 'greedy'
      })
      this.addMarker()
    }
  }
}
</script>