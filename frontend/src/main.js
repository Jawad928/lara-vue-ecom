import { createApp } from 'vue'
import './style.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import Toast from "vue-toastification";
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import 'vue-loading-overlay/dist/css/index.css';
import "vue-toastification/dist/index.css";
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import VueDOMPurifyHTML from 'vue-dompurify-html';
import VueImageZoomer from 'vue-image-zoomer'
import 'vue-image-zoomer/dist/style.css';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'



const pinia = createPinia();
pinia.use(piniaPluginPersistedstate)


createApp(App)
    .use(router)
    .use(VueDOMPurifyHTML)
    .use(pinia)
    .use(Toast)
    .use(VueImageZoomer)
    .mount('#app')
