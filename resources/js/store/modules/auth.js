import axios from 'axios';
import Vue from 'vue';
import {getStorageItem, removeStorageItem, setStorageItem} from "@/utils/localStorage";
import router from "@/router";

export default {
    namespaced: true,
    state: {
        user: getStorageItem('user'),
        token_id: getStorageItem('token_id'),
    },

    mutations: {
        setUser: (state, payload) => {
            setStorageItem('user', state, payload)
            setStorageItem('token_id', state, payload.token_id)
        },
        logOut: (state) => {
            removeStorageItem('user', state);
            removeStorageItem('token_id', state);
        }
    },

    actions: {
        async LogIn({commit}, User) {
            const response = await axios.post('login', User)
                .then(res => {
                    if (res.data.error) {
                        Vue.prototype.$flashStorage.flash(res.data.message, 'error');
                        return false;
                    } else {
                        return res.data;
                    }
                })
                .catch((error) => console.log(error))
            if (response) {
                await commit('setUser', response)
                router.push({name: 'Main'})
            }
        },

        async LogOut({commit, getters}) {
            if (getters.token_id) {
                await axios.post('logout', {token_id: getters.token_id})
                    .then(res => {
                        if (res.data.success) {
                            commit('logOut');
                            localStorage.clear();
                            router.push({name: 'Login'})
                        }
                    })
                    .catch(err => console.log(err))
            }
        }
    },

    getters: {
        auth: state => !!state.user,
        token_id: state => state.token_id,
        user: state => state.user,
    }
}
