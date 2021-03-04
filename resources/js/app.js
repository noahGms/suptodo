require('./bootstrap');

import { createApp } from 'vue';
import Router from './router/index';
import Store from "./store/index";
import App from './App.vue';

import axios from "axios";

axios.defaults.url = "/api";

createApp(App).use(Router).use(Store).mount("#app");