import axios from 'axios';
import Vue from 'vue';

import {getStorageItem, setStorageItem, removeStorageItem} from '@/utils/localStorage';

export default {
    namespaced: true,
    state: {
        users: getStorageItem('users')
    },

    mutations: {
        setUsers: (state, payload) => {
            setStorageItem('users', state, payload);
        },
    },

    actions: {
        async fetchUsers({commit}, ) {
            commit('common/setLoader', null, {root: true})
            try {
                const response = await axios.get('users');
                commit('setUsers', response.data);
            } catch (response) {
                console.log(response.data.error);
            }

            commit('common/removeLoader', null, {root: true})
        },
    },
    getters: {
        users: s => s.users,
    }
}
