import {getStorageItem, setStorageItem} from "@/utils/localStorage";
import axios from "axios";
import Vue from "vue";

export default {
    namespaced: true,
    state: {
        check: getStorageItem('check'),
    },

    mutations: {
        setCheck: (state, payload) => {
            setStorageItem('check', state, payload);
        }
    },

    actions: {
        async sendApprove({getters, rootGetters}) {
            const data = {
                token_id: rootGetters['auth/token_id'],
                id: getters.check.id,
                image: getters.check.receipt
            }
            await axios.post('approve', data)
                .then(res => {
                    if (res.data.success) {
                        Vue.prototype.$flashStorage.flash(res.data.message, 'success');
                    } else {
                        Vue.prototype.$flashStorage.flash(res.data.message, 'error');
                    }
                })
                .catch(err => console.log(err))
        },
        async sendReject({getters, rootGetters}, comment) {
            const data = {
                token_id: rootGetters['auth/token_id'],
                id: getters.check.id,
                comment,
                image: getters.check.receipt
            }
            await axios.post('reject', data)
                .then(res => {
                    if (res.data.success) {
                        Vue.prototype.$flashStorage.flash(res.data.message, 'success');
                    } else {
                        Vue.prototype.$flashStorage.flash(res.data.message, 'error');
                    }
                })
                .catch(err => console.log(err))

        },
        async fetchCheckItem({commit, rootGetters}) {
            commit('common/setLoader', null, {root: true})
            await axios.post('purchase-item', {token_id: rootGetters['auth/token_id']})
                .then(res => {
                    commit('setCheck', res.data)
                })
                .catch(err => console.log(err))
            commit('common/removeLoader', null, {root: true})
        }
    },
    getters: {
        check: state => state.check,
    }
}
