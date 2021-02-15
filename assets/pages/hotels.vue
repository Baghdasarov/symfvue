<template>
  <div>
    <select name="hotel" v-model="hotel" id="hotel" v-on:change="fetchReviews">
      <option :value="null" selected>Select hotel</option>
      <option :value="id" :key="id" v-for="(name, id) in hotels">{{ name }}</option>
    </select>
    <datepicker placeholder="From" v-model="dateFrom" v-on:selected="fetchReviews"></datepicker>
    <datepicker placeholder="To" v-model="dateTo" v-on:selected="fetchReviews"></datepicker>

    <review-chart :chartdata="chartScores" :width="5" :height="1"/>
  </div>
</template>

<script>
import axios from "axios";
import Datepicker from 'vuejs-datepicker';
import ReviewChart from './review-chart'

export default {
  name: "Hotels",
  components: {
    Datepicker,
    ReviewChart
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
    fetchReviews() {
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
  },
  computed: {
    chartScores() {
      return {
        labels: this.scores.map(i => i['date']),
        datasets: [{
          data: this.scores.map(i => i['score']),
        }]
      }
    }
  }
}
</script>

<style scoped>

</style>
