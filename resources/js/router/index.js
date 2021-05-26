import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store'

import Auth from '@/layouts/Auth';
import Login from '@/pages/auth/Login';
import Logout from '@/pages/auth/Logout';
import MainLayout from '@/layouts/Main';
import Main from '@/pages/main/Main';
import History from '@/pages/history/History';

Vue.use(VueRouter);

Vue.router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/auth',
            component: Auth,
            meta: {auth: false},
            children: [
                {
                    path: 'login',
                    name: 'Login',
                    component: Login,
                },
                {
                    path: 'logout',
                    name: 'Logout',
                    component: Logout,
                    meta: {auth: true},
                }
            ]
        },
        {
            path: '/',
            component: MainLayout,
            meta: {auth: true},
            children: [
                {
                    path: '/',
                    name: 'Main',
                    component: Main,
                },
                {
                    path: '/history',
                    name: 'History',
                    component: History
                },
                {
                    path: '*',
                    meta: {
                        auth: undefined,
                        title: 'Ckekapps - 404'
                    },
                    name: 'NotFound',
                    component: () => import('@/pages/404/NotFound.vue'),
                },
            ]
        },

    ]
});

export default Vue.router;
