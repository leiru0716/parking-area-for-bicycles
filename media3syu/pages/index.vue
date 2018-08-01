<template>
<GmapMap
  :center="center"
  :zoom="12"
  map-type-id="terrain"
  style="height: 100%"
>
aa
  <GmapMarker
    :key="index"
    v-for="(maker, index) in markers"
    :position="maker.latLng"
    :clickable="true"
    :draggable="false"
    @click="maker.ifw = !maker.ifw"
  >
    <gmap-info-window :opened="maker.ifw">{{maker.ifwtext}}</gmap-info-window>
  </GmapMarker>
</GmapMap>
</template>
<script>
import axios from 'axios'
// let data
let parkingData
// data = JSON.parse('{"id":"1414","0":"1414","latitude":"36.5806","1":"36.5806","longitude":"136.648722","2":"136.648722","genre":"駐車場・駐輪場","3":"駐車場・駐輪場","name":"駐車場","4":"駐車場","outline":"","5":"","postalcode":"","6":"","address":"","7":"","phonenumber":"","8":"","opentime":"金沢駅西口時計駐車場","9":"金沢駅西口時計駐車場","closingday":"収容台数：1500台","10":"収容台数：1500台","price":"920-0031","11":"920-0031","remarks":"金沢市広岡1-401","12":"金沢市広岡1-401","link":"076-263-5151","13":"076-263-5151"}')

export default {
  data () {
    return {
      center: { lat: 36.57, lng: 136.64 },
      markers: [
      //   {
      //     latLng: { lat: Number(data.latitude), lng: Number(data.longitude) },
      //     ifw: false,
      //     ifwtext: ''
      //   }
      ]
    }
  },
  mounted () {
    // console.log(data)
    axios.get('http://192.168.207.133').then(response => {
      parkingData = response.data
      for (let i = 0; i < parkingData.length; i++) {
        this.markers.push({
          latLng: { lat: Number(parkingData[i][0].latitude), lng: Number(parkingData[i][0].longitude) },
          ifw: false,
          ifwtext: parkingData[i][0].opentime + '\n ' + parkingData[i][0].closingday})
        // console.log(parkingData[i][0])
      }
      // console.log(parkingData[0][0].latitude)
    })
  }
}
</script>