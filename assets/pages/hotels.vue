<template>
  <div>
    <select name="hotel" v-model="hotel" id="hotel" v-on:change="fetchReviews">
      <option :value="null" selected>Select hotel</option>
      <option :value="id" :key="id" v-for="(name, id) in hotels">{{name}}</option>
    </select>
    <datepicker placeholder="From" v-model="dateFrom"></datepicker>
    <datepicker placeholder="To" v-model="dateTo"></datepicker>
  </div>
</template>

<script>
import axios from "axios";
import Datepicker from 'vuejs-datepicker';

export default {
  name: "Hotels",
  components: {
    Datepicker
  },
  data() {
    return {
      hotel: null,
      hotels: [],
      scores: [],
      dateFrom: null,
      dateTo: null
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

      const from = this.dateFrom ? this.dateFrom.toISOString() : null;
      const to = this.dateTo ? this.dateTo.toISOString() : null;

      axios.get(`/reviews/${this.hotel}`, {
        params: {
          from,
          to
        }
      }).then(res => this.scores = res['data'])
    }
  }
}
</script>

<style scoped>

</style>
