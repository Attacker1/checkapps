import Vue from 'vue';
import axios from '@websanova/vue-auth/drivers/http/axios.1.x';
import auth from '@websanova/vue-auth/src/index.js';
import authBearer from './bearer.js';
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x';


Vue.use(auth, {
    auth: authBearer,
    http: axios,
    router: router,
    rolesKey: 'type',
    tokenDefaultKey: 'token',

    // Redirects
    authRedirect: {name: 'Login'},
    forbiddenRedirect: {path: '/403'},
    notFoundRedirect: {path: '/404'},

    // Http
    registerData: {
        url: 'register',
        method: 'POST',
        redirect: '/',
        autoLogin: true
    },
    loginData: {
        url: 'login',
        method: 'POST',
        redirect: '/',
    },
    refreshData: {
        url: 'users/token/refresh',
        method: 'POST',
        enabled: false,
        interval: 10
    },
    fetchData: {
        url: 'user',
        enabled: true,
    },

    parseUserData: data => data,
});

