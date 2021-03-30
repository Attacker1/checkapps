import Vue from 'vue';

import axios from 'axios';
import router from '@/router';
import store from '@/store'
import VueAxios from 'vue-axios';

axios.defaults.withCredentials = true
axios.defaults.baseURL = process.env.VUE_APP_API_URL;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.response.use(undefined, function (error) {
    if (error) {
        const originalRequest = error.config;
        if (error.response.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;
            store.dispatch('auth/LogOut')
                .then(() => router.push({name: 'Login'}))
        }
    }
});

Vue.use(VueAxios, axios);

export default {
    root: process.env.VUE_APP_API_URL
};
