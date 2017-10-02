<template>
  <div id="app">
    <div is="AppLayout"></div>
  </div>
</template>

<script>
import AppLayout from './AppLayout.vue';

export default {
  name: 'App',
  data () {
    return {
      msg: "12345!!!"
    }
  },
  components: {
    'AppLayout': AppLayout
  }
}
</script>