import { createApp } from 'vue'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap"
import App from './App.vue'
import router from './router'
import store from './store'
import Highcharts from "highcharts";
import Gantt from "highcharts/modules/gantt";
import HighchartsVue from "highcharts-vue";

Gantt(Highcharts);

createApp(App).use(store).use(HighchartsVue).use(router).mount('#app')
