<script>
import {Line} from 'vue-chartjs'

export default {
  extends: Line,
  name: "review-chart",
  props: ['chartdata', 'options'],
  watch: {
    chartdata() {
      this.renderChart(this.chartdata, this.options)
    }
  },
}
</script>

<style scoped>

</style>
