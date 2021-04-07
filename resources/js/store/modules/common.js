export default {
    namespaced: true,
    state: {
        loader: false,
        windowSize: null,
    },

    mutations: {
        setLoader: (state) => {
            state.loader = true
        },
        removeLoader: (state) => {
            state.loader = false
        },
        setWindowSize: (state, payLoad) => {
            state.windowSize = payLoad;
        }
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
        windowSize({commit}, size) {
            commit('setWindowSize', size);
        }
    },
    getters: {
        loader: s => s.loader
    }
}
