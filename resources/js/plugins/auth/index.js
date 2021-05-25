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
    authRedirect: {name: 'Main'},
    forbiddenRedirect: {path: '/403'},
    notFoundRedirect: {path: '/404'},
    loginData: {
        url: 'login',
        method: 'POST',
        redirect: '/',
    },
    logoutData: {
        success: function (){
            this.token(this.options.refreshTokenName, 'INVALID');
        },
    },
    fetchData: {
        url: 'user',
        enabled: true,
    },
    refreshTokenName: 'refresh_token',

    parseUserData: data => data,
});
