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
            setStorageItem('token_id', state, payload.user.token_id)
        },
        resetUser: (state) => {
            removeStorageItem('user', state);
            removeStorageItem('token_id', state);
        },
    },

    actions: {
        async LogIn({commit, dispatch}, User) {
            commit('common/setLoader', null, {root: true})
            const response = await axios.post('login', User)
                .then(res => {
                    if (res.data.error) {
                        Vue.noty.error(res.data.error);
                        commit('common/removeLoader', null, {root: true})
                        return false;
                    } else {
                        return res.data;
                    }
                })
                .catch((error) => console.log(error))
            if (response) {
                await commit('setUser', response)
                dispatch('checks/fetchChecks', null, {root: true})
                router.push({name: 'Main'})
            }
        },

        LogOut({dispatch}) {
            dispatch('common/resetStore', null, {root: true})
            router.push({name: 'Login'})
        }
    },

    getters: {
        auth: state => !!state.user,
        token_id: state => state.token_id,
        user: state => state.user,
    }
}
