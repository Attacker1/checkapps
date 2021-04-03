export default {
    namespaced: true,
    state: {
        loader: false,
    },

    mutations: {
        setLoader: (state) => {
            state.loader = true
        },
        removeLoader: (state) => {
            state.loader = false
        },
    },

    actions: {
        loaderOn({commit}) {
            commit('setLoader');
        },
        loaderOff({commit}) {
            commit('removeLoader');
        },
        resetStore({commit}) {
            commit('auth/resetUser', null, {root: true})
            commit('currentCheck/resetCurrentCheck', null, {root: true})
            commit('checks/removeChecks', null, {root: true})
            localStorage.clear();
        },

    },
    getters: {
        loader: s => s.loader
    }
}
