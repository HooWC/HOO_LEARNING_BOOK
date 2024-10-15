import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import 'vuetify/styles'
import 'vuetify/dist/vuetify.css';
import '@mdi/font/css/materialdesignicons.css'
import router from './routers/index.js'

const vuetify = createVuetify({
    components,
    directives,
})

const app = createApp(App)

app.use(vuetify)
app.use(router)

app.mount('#app')