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
                check_id: currentCheck.check_id,
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
            setTimeout(() => {  commit('common/removeLoader', null, {root: true}); }, 200);
        },

        async sendReject({getters, rootGetters, commit, dispatch}, comment) {
            commit('common/setLoader', null, {root: true})

            const currentCheck = rootGetters['currentCheck/currentCheck'];
            const data = {
                check_id: currentCheck.check_id,
                comment,
            }
            await axios.post('reject', data)
                .then(res => {
                    if (res.data.success) {
                        Vue.noty.error(res.data.message);
                        dispatch('currentCheck/removeFromChecks', null, {root: true});
                    } else {
                        Vue.noty.error(res.data.message);
                    }
                })
                .catch(err => console.log(err))

            setTimeout(() => {  commit('common/removeLoader', null, {root: true}); }, 200);
        },

        skipCheck({dispatch, commit, rootGetters}) {
            commit('common/setLoader', null, {root: true})
            const currentCheck = rootGetters['currentCheck/currentCheck'];
            console.log('SkipCheck: ' + currentCheck.check_id);
            axios.post('skip', {check_id: currentCheck.check_id})
                .then(res => {
                    const response = res.data;
                    if (response.success) {
                        dispatch('currentCheck/removeFromChecks', null, {root: true})
                        Vue.noty.show(response.message);
                    } else {
                        Vue.noty.error(response.message);
                    }
                });
            setTimeout(() => {  commit('common/removeLoader', null, {root: true}); }, 200);
        },
    },
    getters: {
        check: state => state.check,
    }
}
