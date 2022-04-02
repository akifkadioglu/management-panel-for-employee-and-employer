import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { ClientTable } from 'vue-tables-2';
const moment = require('moment')
require('moment/locale/tr')
import "./plugins/apexChart";
import excel from 'vue-excel-export'
 
Vue.use(excel)
Vue.use(require('vue-moment'), {
  moment
})
Vue.use(ClientTable, {
  perPage: 40
});
Vue.use(VueMaterial)
Vue.config.productionTip = false
Vue.use(VueAxios, axios)
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
