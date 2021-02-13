<template>
  <select name="hotel" v-model="hotel" id="hotel">
    <option :value="null" selected>Select hotel</option>
    <option :value="id" :key="id" v-for="(name, id) in hotels">{{name}}</option>
  </select>
</template>

<script>
import axios from "axios";

export default {
  name: "Hotels",
  data() {
    return {
      hotel: null,
      hotels: []
    }
  },
  mounted() {
    const self = this;

    axios.get('/hotels').then(res => {
      self.hotels = res['data']['data']
    })
  }
}
</script>

<style scoped>

</style>
