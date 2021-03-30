export default {
    namespaced: true,
    state: {
        reject: null,
        approve: null,
        purchaseList: null,
    },

    mutations: {
        setApprove: (state, payload) => {
            state.approve = payload
        },
        setReject: (state, payload) => {
            state.reject = payload
        },
        setPurchaseList: (state, payload) => {
            state.purchaseList = payload
        }
    },

    actions: {
        sendApprove({commit}) {
            commit('setApprove');
        },
        sendReject({commit}) {
            commit('setReject');
        },
        fetchPurchaseList({commit}) {
            commit('setReject');
        }
    },
}
