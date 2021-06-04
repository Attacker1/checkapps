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
        },
    },

    actions: {
        async fetchChecks({commit, state}, force= false) {

            commit('common/setLoader', null, {root: true})

            try {
                if ((!state.checks || state.checks.length <= 1) || force) {
                    await Vue.prototype.$recaptchaLoaded();
                    const token = await Vue.prototype.$recaptcha('check');
                    const response = await axios.get('purchase-items',{
                        params: {
                            recaptcha_token: token
                        }
                    });
                    commit('setChecks', response.data)
                    commit('currentCheck/setCurrentCheck', state.checks[0], {root: true})
                    commit('setExpiryTime')
                }
            } catch (res) {
                Vue.noty.error(res.data.error ? res.data.error : res.data.message);
            }

            commit('common/removeLoader', null, {root: true})
        },

        checkExpiryTime({dispatch, state}) {
            const now = new Date();
            if (state.expiry && (now.getTime() > state.expiry)) {
                dispatch('fetchChecks', {force: true});
            }
        },
        async resetAllChecks() {
            await axios.post('reset-checks')
                .then(res => console.log(res.data))
                .catch(err => console.log(err))
        },
    },
    getters: {
        checks: s => s.checks
    }
}
