<template>
  <select name="hotel" v-model="hotel" id="hotel" v-on:change="fetchReviews">
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
      hotels: [],
      scores: []
    }
  },
  mounted() {
    axios.get('/hotels').then(res => this.hotels = res['data']['data'])
  },
  methods: {
    fetchReviews(){
      if (!this.hotel) {
        this.scores = [];
        return;
      }

      axios.get(`/reviews/${this.hotel}`).then(res => this.scores = res['data'])
    }
  }
}
</script>

<style scoped>

</style>
