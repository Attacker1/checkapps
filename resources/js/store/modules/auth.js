import axios from 'axios';
import Vue from 'vue';
import {getStorageItem, removeStorageItem, setStorageItem} from "@/utils/localStorage";
import router from "@/router";

export default {
    namespaced: true,
    state: {
        userInfo: getStorageItem('user'),
        token_id: getStorageItem('token_id'),
    },

    mutations: {
        setUser: (state, payload) => {
            setStorageItem('user', state, payload)
            setStorageItem('token_id', state, payload.user.token_id)
        },
        resetUser: (state) => {
            removeStorageItem('user', state);
            removeStorageItem('token_id', state);
        },
    },

    actions: {
        login(ctx, data) {
            data = data || {};
            return Vue.auth.login({
                data: data.body,
                fetchUser: true,
                staySignedIn: true,
            }).then((res) => {
                Vue.router.push({name: 'Main'});
                return res;
            });
        },

        logout() {
            /* reset localStorage */
            localStorage.clear();
            return Vue.auth.logout({redirect: {name: 'Logout'}});
        },
    },

    getters: {
        auth: state => !!state.userInfo,
        token_id: state => state.token_id,
        user: state => state.userInfo,
    }
}
