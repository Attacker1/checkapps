import {getStorageItem, setStorageItem} from "@/utils/localStorage";
import axios from "axios";

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
        sendApprove({commit}) {
            commit('setApprove');
        },
        sendReject({commit}) {
            commit('setReject');
        },
        async fetchCheckItem({commit, rootGetters}) {
            await axios.post('purchase-item', {token_id: rootGetters['auth/token_id']})
                .then(res => {
                    commit('setCheck', res.data)
                })
                .catch(err => console.log(err))
        }
    },
    getters: {
        check: state => state.check,
    }
}
