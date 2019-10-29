<template>
  <div
    id="dashboardPage"
    class="main-content">
    <div class="row">
      <div class="col-lg-12 col-xl-12 mt-2">
        <div class="card">
          <div class="card-header">
            Filters
          </div>
          <div class="card-body">
            <div class="form-group col-md-3">
              <label>Student Ids</label>
              <select class="form-control" v-model="submit.student_id" @change="getSubjectData">
                <option v-for="id in filters.student_ids" :value="id.student_id">{{id.student_id}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Year</label>
              <select class="form-control" v-model="submit.calender_year" @change="getSubjectData">
                <option v-for="id in filters.years" :value="id.calender_year">{{id.calender_year}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Grade</label>
              <select class="form-control" v-model="submit.grade" @change="getSubjectData">
                <option value="">Please select grade</option>
                <option v-for="id in filters.grades" :value="id.grade.trim()">{{id.grade}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label>Subject</label>
              <select class="form-control" v-model="submit.subject" @change="getSubjectData">
                <option v-for="id in filters.subjects" :value="id.subject">{{id.subject}}</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-xl-6 mt-2">
        <div class="card">
          <div class="card-header">
            <h6><i class="icon-fa icon-fa-line-chart text-warning"/>Subject Marks</h6>
          </div>
          <div class="card-body">
            <highcharts ref="plotChart" :options="boxPlotChartOptions"></highcharts>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-xl-6 mt-2">
        <div class="card">
          <div class="card-header">
            <h6><i class="icon-fa icon-fa-bar-chart text-success"/>Marks and Averages</h6>
          </div>
          <div class="card-body">
            <highcharts ref="boxChart" :options="boxChartOptions"></highcharts>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-xl-12 mt-2">
        <div class="card">
          <div class="card-header">
            <h6><i class="icon-fa icon-fa-line-chart text-warning"/>Student Marks</h6>
          </div>
          <div class="card-body">
            <highcharts ref="splineChart" :options="splineChartOptions"></highcharts>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import Highcharts from 'highcharts'
import {Chart} from 'highcharts-vue'
import HighchartsMore from 'highcharts/highcharts-more'

HighchartsMore(Highcharts)
export default {
  components: {
    highcharts: Chart
  },
  data () {
    return {
      'header': 'header',
      filters: {},
      submit: {
        student_id:"SID-1",
        grade:"",
        calender_year:"2009",
        subject:"Algebra"
      },
      boxPlotChartOptions: {
        chart: {
          type: 'boxplot'
        },

        plotOptions: {
          boxplot: {
            turboThreshold: 2000
          }
        },

        title: {
          text: 'Marks Analysis'
        },

        legend: {
          enabled: false
        },

        xAxis: {
          categories: [],
          title: {
            text: 'Subjects'
          }
        },

        yAxis: {
          title: {
            text: 'Marks'
          }
        },

        series: []
      },
      boxChartOptions: {
        title: {
          text: 'Subjects Analysis'
        },
        xAxis: {
          categories: [],
          title: {
            text: 'Subjects'
          },
          crosshair: true
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Marks'
          }
        },
        plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
          }
        },
        series: [
          {
            name: 'Marks',
            type: 'column',
            data: [
            ]
          },
          {
            name: 'Average',
            type: 'spline',
            data: [
            ]
          }
        ]
      },
      splineChartOptions: {
        chart: {
          height: 500,
        },
        title: {
          text: 'Student Marks Analysis'
        },
        xAxis: {
          categories: [],
          title: {
            text: 'Year & Semester'
          },
          crosshair: true
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Marks'
          }
        },
        plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
          }
        },
        series: []
      }
    }
  },
  methods: {
    getFilters() {
      let self = this;
      axios.get('/api/admin/analysis/filterInformation/').then((response) => {
        console.log(response.data.result);
        self.filters = response.data.result;
      })
    },
    getSubjectData() {
      this.getPlotSubjectData();
      this.getBoxSubjectData();
      this.getMarksData();
    },
    getBoxPlotData(values) {
      var sorted = values.sort(function (a, b) {
        return a - b;
      });

      return {
        low: sorted[0],
        q1: sorted[Math.round(values.length * 0.25)],
        median: sorted[Math.round(values.length * 0.5)],
        q3: sorted[Math.round(values.length * 0.75)],
        high: sorted[sorted.length - 1]
      };
    },
    getPlotSubjectData() {
      //this.boxPlotChartOptions.series[0].data = [];
      let self = this;
      var queryString = Object.keys(this.submit).map(key => key + '=' + this.submit[key]).join('&');
      axios.get(`/api/admin/analysis/subjectPlotData?${queryString}`).then((response) => {
        let data = response.data.result;

        var scatterData = data.series
                .reduce(function (acc, data, x) {
                  return acc.concat(data.map(function (value) {
                    return [x, value];
                  }));
                }, []);

        var boxplotData = data.series
                .map(this.getBoxPlotData);

        self.boxPlotChartOptions.series = [{
          type: 'boxplot',
          name: 'Summary',
          data: boxplotData,
        }, {
          name: 'Observation',
          type: 'scatter',
          data: scatterData,
          jitter: {
            x: 0.24 // Exact fit for box plot's groupPadding and pointPadding
          },
          marker: {
            radius: 1
          },
          color: 'rgba(100, 100, 100, 0.5)',
        }];
        self.boxPlotChartOptions.xAxis.categories = data.categories;
      })
    },
    getBoxSubjectData() {
      let self = this;
      var queryString = Object.keys(this.submit).map(key => key + '=' + this.submit[key]).join('&');
      axios.get(`/api/admin/analysis/subjectBoxData?${queryString}`).then((response) => {
        let data = response.data.result;
        self.boxChartOptions.series[0].data = data.series[0];
        self.boxChartOptions.series[1].data = data.series[1];
        self.boxChartOptions.xAxis.categories = data.categories;
      })
    },
    getMarksData() {
      let self = this;
      var queryString = 'student_id='+this.submit.student_id;
      self.splineChartOptions.series = [];
      axios.get(`/api/admin/analysis/marksData?${queryString}`).then((response) => {
        let data = response.data.result;
        self.splineChartOptions.xAxis.categories = data.categories;
        console.log(data.series);
        Object.keys(data.series).forEach(function(key) {
          self.splineChartOptions.series.push({
            name: key,
            type: 'spline',
            data: data.series[key]
          });
        });
      })
    }
  },
  mounted() {
    this.getFilters();
    this.getSubjectData();
  }
}
</script>
<style lang="scss">
  .form-group {
    float: left;
  }
</style>
