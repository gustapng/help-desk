import './assets/main.css'

import axios from 'axios'
import { createPinia } from 'pinia'
import { createApp } from 'vue'

import App from './App.vue'
import router from './router'

axios.defaults.baseURL = 'http://localhost:80'
axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

let csrfFetched = false

axios.interceptors.request.use(async (config) => {
  if (
    !csrfFetched &&
    ['post', 'put', 'patch', 'delete'].includes(config.method?.toLowerCase() || '')
  ) {
    await axios.get('/sanctum/csrf-cookie')
    csrfFetched = true
  }
  return config
})

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
