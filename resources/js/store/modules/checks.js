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
            } catch (response) {
                console.log(response.data.error);
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
// {"check_id":19319550,"image":"https://api.thefiniko.com/upload/cashback_purchase/20210603/c3d6f1b000e9438b56b5f1d5a55b66aa.jpg.webp","amount":2.1,"amount_in_currency":154,"dt":"2021-06-03 11:06:41","dt_purchase":"2021-06-01 11:05:44","currency":"RUB","verify_quantity":5,"current_quantity":0,"status":"INCHECK","created_at":"2021-06-03T08:10:59.000000Z","updated_at":"2021-06-03T12:42:37.000000Z","check_user_id":513753}
