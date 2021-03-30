import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store'

import Auth from '@/layouts/Auth';
import Login from '@/pages/auth/Login';
import Logout from '@/pages/auth/Logout';
import MainLayout from '@/layouts/Main';
import Main from '@/pages/main/Main';

Vue.use(VueRouter);

const router = new VueRouter({
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
            ]
        },

    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.auth))
        if (store.getters['auth/auth']) next()
        else next({name: 'Login'});
    else next();
});

export default router;
