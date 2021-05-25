import axios from 'axios';
import Vue from 'vue';

import {getStorageItem, setStorageItem, removeStorageItem} from '@/utils/localStorage';

export default {
    namespaced: true,
    state: {
        checks: getStorageItem('checks'),
        expiry: getStorageItem('expiry'),
    },

    mutations: {
        setChecks: (state, payload) => {
            setStorageItem('checks', state, payload);
        },

        setExpiryTime: (state) => {
            const now = new Date();
            setStorageItem('expiry', state, now.getTime() + 1000 * 60 * 60)
        },
        removeChecks: (state) => {
            removeStorageItem('checks', state)
            removeStorageItem('expiry', state)
        }
    },

    actions: {
        async fetchChecks({commit, rootGetters, state}) {
            commit('common/setLoader', null, {root: true})
            await axios.get('purchase-items')
                .then(res => {
                    commit('setChecks', res.data)
                    console.log(state.checks[0])
                    commit('currentCheck/setCurrentCheck', state.checks[0], {root: true})
                    commit('setExpiryTime')
                })
                .catch(err => console.log(err))

            commit('common/removeLoader', null, {root: true})
        },

        checkExpiryTime({dispatch, state}) {
            const now = new Date();
            if (state.expiry && (now.getTime() > state.expiry)) {
                dispatch('fetchChecks');
            }
        }
    },
    getters: {
        checks: s => s.checks
    }
}
