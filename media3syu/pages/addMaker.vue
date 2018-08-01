<template>
<v-container fluid >
  <div>
    <GmapMap style="height: 400px;" :zoom="12" :center="{ lat: 36.57, lng: 136.64 }" 
        ref="map" @click="clicked" >
      <GmapMarker v-if="start" :position="start.latLng" label="S" />
      <GmapMarker v-if="end" :position="end.latLng" label="E" />
      <GmapPolyline v-if="curvedPath" :path="curvedPath" />
    </GmapMap>
    <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="id"
      :counter="10"
      label="id"
      required
    ></v-text-field>
    <v-text-field
      v-model="緯度"
      label="latitude"
      required
    ></v-text-field>
    <v-text-field
      v-model="経度"
      label="longitude"
      required
    ></v-text-field>
    <v-text-field
      v-model="ジャンル"
      label="genre"
    ></v-text-field> 
    <v-text-field
      v-model="名称"
      label="name"
      required
    ></v-text-field> 
    <v-text-field
      v-model="概略"
      label="outline"
      required
    ></v-text-field> 
    <v-text-field
      v-model="郵便番号"
      label="postalcode"
      required
    ></v-text-field>
    <v-text-field
      v-model="住所"
      label="phonenumber"
      required
    ></v-text-field>
    <v-text-field
      v-model="電話番号"
      label="opentime"
      required
    ></v-text-field>
    <v-text-field
      v-model="開館時間"
      label="closingday"
      required
    ></v-text-field>
    <v-text-field
      v-model="休館時間"
      label="price"
      required
    ></v-text-field>
    <v-text-field
      v-model="備考"
      label="remarks"
    ></v-text-field>
    <v-text-field
      v-model="リンク"
      label="link"
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
import {range} from 'lodash'
import axios from 'axios'

export default {
  data () {
    return {
      start: null,
      end: null,
      valid: true,
      name: '',
      nameRules: [
        v => !!v || 'Name is required',
        v => (v && v.length <= 10) || 'Name must be less than 10 characters'
      ],
      email: '',
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+/.test(v) || 'E-mail must be valid'
      ],
      select: null,
      items: [
        'Item 1',
        'Item 2',
        'Item 3',
        'Item 4'
      ],
      checkbox: false
    }
  },
  description: `
  In which a curved polyline is drawn on the map
  `,
  computed: {
    curvedPath () {
      /*
        FIXME: This formula will work for short distances away from
          the poles. It will not work once the curvature of the earth is
          too great
      */
      if (this.start && this.end) {
        return range(100)
          .map(i => {
            const tick = i / 99

            /* Bezier curve -- set up the control points */
            const dlat = this.end.latLng.lat() - this.start.latLng.lat()
            const dlng = this.end.latLng.lng() - this.start.latLng.lng()

            const cp1 = {
              lat: this.start.latLng.lat() + 0.33 * dlat + 0.33 * dlng,
              lng: this.start.latLng.lng() - 0.33 * dlat + 0.33 * dlng
            }

            const cp2 = {
              lat: this.end.latLng.lat() - 0.33 * dlat + 0.33 * dlng,
              lng: this.end.latLng.lng() - 0.33 * dlat - 0.33 * dlng
            }

            /* Bezier curve formula */
            return {
              lat:
                (tick * tick * tick) * this.start.latLng.lat() +
                3 * ((1 - tick) * tick * tick) * cp1.lat +
                3 * ((1 - tick) * (1 - tick) * tick) * cp2.lat +
                ((1 - tick) * (1 - tick) * (1 - tick)) * this.end.latLng.lat(),
              lng:
                (tick * tick * tick) * this.start.latLng.lng() +
                3 * ((1 - tick) * tick * tick) * cp1.lng +
                3 * ((1 - tick) * (1 - tick) * tick) * cp2.lng +
                ((1 - tick) * (1 - tick) * (1 - tick)) * this.end.latLng.lng()
            }
          })
      }
    }
  },
  methods: {
    clicked (e) {
      if (!this.start && !this.end) {
        this.start = {
          latLng: e.latLng
        }
      } else if (this.start && !this.end) {
        this.end = {
          latLng: e.latLng
        }
      } else {
        this.start = {
          latLng: e.latLng
        }
        this.end = null
      }
    },
    submit () {
      if (this.$refs.form.validate()) {
        // Native form submission is not yet supported
        axios.post('/api/submit', {
          name: this.name,
          email: this.email,
          select: this.select,
          checkbox: this.checkbox
        })
      }
    },
    clear () {
      this.$refs.form.reset()
    }
  }
}
</script>