import './bootstrap';
import { createApp} from 'vue'
import router from './router';
import App from './App.vue';
import VueClickAway from "vue3-click-away";

const app  = createApp(App);

app
    .use(VueClickAway)
    .use(router)
    .mount('#app')