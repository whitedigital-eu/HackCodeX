import './assets/main.scss'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import {createPinia} from "pinia";
import VueApexCharts from "vue3-apexcharts";

const pinia = createPinia()
const app = createApp(App)

app.use(router)
app.use(pinia)
app.use(VueApexCharts)

app.mount('#app')
