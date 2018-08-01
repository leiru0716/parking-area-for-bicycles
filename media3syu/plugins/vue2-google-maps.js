import Vue from 'vue'

import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyCM-AMmwI8j_7n0uQXjKSgpQK-_Rdj3iGw',
    libraries: 'places'
  }
})
