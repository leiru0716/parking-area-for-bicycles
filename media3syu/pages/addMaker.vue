<template>
<v-container fluid >
  <div>
    <GmapMap style="height: 400px;" :zoom="12" :center="{ lat: 36.57, lng: 136.64 }" 
        ref="map" @click="clicked" >
      <GmapMarker v-if="start" :position="start.latLng"  />
    </GmapMap>
    <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="id"
      label="id"
      :rules="Rules"
      required
    ></v-text-field>
    <v-text-field
      v-model="latitude"
      label="緯度"
      required
    ></v-text-field>
    <v-text-field
      v-model="longitude"
      label="経度"
      required
    ></v-text-field>
    <v-text-field
      v-model="genre"
      label="ジャンル"
    ></v-text-field> 
    <v-text-field
      v-model="opentime"
      label="名称"
      required
    ></v-text-field> 
    <v-text-field
      v-model="closingday"
      label="概略"
      required
    ></v-text-field> 
    <v-text-field
      v-model="postalcode"
      label="郵便番号"
      required
    ></v-text-field>
    <v-text-field
      v-model="phonenumber"
      label="住所"
      required
    ></v-text-field>
    <v-text-field
      v-model="name"
      label="電話番号"
    ></v-text-field>
    <v-text-field
      v-model="remarks"
      label="開館時間"
    ></v-text-field>
    <v-text-field
      v-model="price"
      label="休館時間"
    ></v-text-field>
    <v-text-field
      v-model="outline"
      label="備考"
    ></v-text-field>
    <v-text-field
      v-model="link"
      label="リンク"
    ></v-text-field>

    <v-btn
      :disabled="!valid"
      @click="submit"
    >
      submit
    </v-btn>
    <v-btn @click="clear">clear</v-btn>
  </v-form>
  </div>
</v-container>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      start: null,
      maker: { latLng: { lat: null, lng: null } },
      valid: true,
      id: '',
      latitude: '',
      longitude: '',
      genre: '',
      name: '',
      outline: '',
      postalcode: '',
      phonenumber: '',
      opentime: '',
      closingday: '',
      price: '',
      remarks: '',
      link: '',
      Rules: [
        v => !!v || 'required'
      ]
    }
  },
  watch: {
    start: function () {
      if (this.start) {
        this.latitude = this.start.latLng.lat()
        this.longitude = this.start.latLng.lng()
        // console.log(String(this.start.latLng.lat()))
      }
    }
  },
  methods: {
    clicked (e) {
      this.start = {
        latLng: e.latLng
      }
      // console.log(this.start)
    },
    submit () {
      if (this.$refs.form.validate()) {
        // Native form submission is not yet supported

        let params = new URLSearchParams()
        params.append('id', this.id)
        params.append('latitude', this.latitude)
        params.append('longitude', this.longitude)
        params.append('genre', this.genre)
        params.append('name', this.name)
        params.append('outline', this.outline)
        params.append('postalcode', this.postalcode)
        params.append('phonenumber', this.phonenumber)
        params.append('opentime', this.opentime)
        params.append('closingday', this.closingday)
        params.append('price', this.price)
        params.append('remarks', this.remarks)
        params.append('link', this.link)
        axios.post('http://192.168.207.133/addmaker.php', params).then(response => console.log(response))
      }
    },
    clear () {
      this.$refs.form.reset()
    }
  }
}
</script>