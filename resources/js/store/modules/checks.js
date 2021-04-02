import axios from 'axios';
import Vue from 'vue';

import {getStorageItem, setStorageItem} from '@/utils/localStorage';

export default {
    namespaced: true,
    state: {
        checks: getStorageItem('checks'),
    },

    mutations: {
        setChecks: (state, payload) => {
            setStorageItem('checks', state, payload);
        },
    },

    actions: {
        async fetchChecks({commit, rootGetters, state}) {
            commit('common/setLoader', null, {root: true})
            await axios.post('purchase-items', {token_id: rootGetters['auth/token_id']})
                .then(res => {
                    commit('setChecks', res.data)
                    commit('currentCheck/setCurrentCheck', state.checks[0], {root: true})
                })
                .catch(err => console.log(err))

            commit('common/removeLoader', null, {root: true})
        },
    },
    getters: {
        checks: s => s.checks
    }
}
