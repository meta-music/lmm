import { createApp } from 'vue';
import App from './view/App.vue'
import { router } from './router';
import { Button } from 'vant';

const app = createApp(App);
app.use(Button)
app.use(router)
app.mount("#app")
