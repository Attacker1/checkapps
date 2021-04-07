import {getStorageItem, setStorageItem} from "@/utils/localStorage";
import axios from "axios";
import Vue from "vue";

export default {
    namespaced: true,
    actions: {
        async sendApprove({rootGetters, dispatch, commit}) {
            commit('common/setLoader', null, {root: true})

            const currentCheck = rootGetters['currentCheck/currentCheck'];
            const data = {
                token_id: rootGetters['auth/token_id'],
                id: currentCheck.id,
                image: currentCheck.receipt,
                user_id: rootGetters['auth/user'].user_id
            }
            await axios.post('approve', data)
                .then(res => {
                    if (res.data.success) {
                        Vue.noty.success(res.data.message);
                        dispatch('currentCheck/removeFromChecks', null, {root: true})
                    } else {
                        Vue.noty.error(res.data.message);
                    }
                })
                .catch(err => console.log(err))
            commit('common/removeLoader', null, {root: true})
        },

        async sendReject({getters, rootGetters, commit, dispatch}, comment) {
            commit('common/setLoader', null, {root: true})

            const currentCheck = rootGetters['currentCheck/currentCheck'];
            const data = {
                token_id: rootGetters['auth/token_id'],
                id: currentCheck.id,
                comment,
                image: currentCheck.receipt,
                user_id: rootGetters['auth/user'].user_id
            }
            await axios.post('reject', data)
                .then(res => {
                    if (res.data.success) {
                        Vue.noty.error(res.data.message);
                        dispatch('currentCheck/removeFromChecks', null, {root: true})
                    } else {
                        Vue.noty.error(res.data.message);
                    }
                })
                .catch(err => console.log(err))

            commit('common/removeLoader', null, {root: true})
        },

        skipCheck({dispatch}) {
            dispatch('currentCheck/removeFromChecks', null, {root: true})
            Vue.noty.show('Чек пропущен');
        },
    },
    getters: {
        check: state => state.check,
    }
}
