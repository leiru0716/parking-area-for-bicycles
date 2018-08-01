<template>
  <v-app>
    <v-toolbar fixed app >
        <v-toolbar-title v-text="title"></v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn icon >
        <v-icon>add</v-icon>
      </v-btn>
    </v-toolbar>
    <v-content>
      <nuxt />
    </v-content>
    <v-footer fixed app>
      <v-spacer></v-spacer>
      <span>&copy; 2018 media3syu</span>
    </v-footer>
  </v-app>
</template>

<script>
  export default {
    data () {
      return {
        title: '金沢市 駐車場 駐輪場'
      }
    }
  }
</script>
