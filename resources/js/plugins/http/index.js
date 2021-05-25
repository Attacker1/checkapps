import Vue from 'vue';

import axios from 'axios';
import VueAxios from 'vue-axios';

axios.defaults.withCredentials = true
axios.defaults.baseURL = process.env.MIX_API_URL;

Vue.use(VueAxios, axios);

export default {
    root: process.env.VUE_APP_API_URL
};
