import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

//import './assets/main.css'
//import './z02/frontend/vue-project/dist/assets/index-81e4655a.css'
const app = createApp(App)

app.use(router)

app.use(store)

app.mount('#app')
