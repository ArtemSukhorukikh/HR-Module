import { createApp } from 'vue'
import App from './App.vue'
import store from './store'
import Axios from 'vue-axios'
import bootstrap from 'bootstrap'
import router from 'vue-router'
App.use(Axios)
App.use(store)
App.use(bootstrap)
App.use(router)
App.prototype.$http = Axios;
const token = localStorage.getItem('token')
if (token) {
    App.prototype.$http.defaults.headers.common['Authorization'] = token
}

createApp(App).mount('#app')
