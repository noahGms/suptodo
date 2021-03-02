require('./bootstrap');

import { createApp } from 'vue';
import Router from './router/index';
import Store from "./store/index";
import App from './App.vue';

createApp(App).use(Router).use(Store).mount("#app");