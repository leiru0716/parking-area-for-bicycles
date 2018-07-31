<template>
  <v-layout>
    <v-flex text-xs-center>
      <Map></Map>
      aa
    </v-flex>
  </v-layout>
</template>


<script>
  import gMap from '~/components/Map'

  export default {
    data () {
      return {
        value: 0,
        e1: 0,
        fillColor: '#000000'
      }
    },
    components: {
      gMap
    }
  }
</script>
