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
        resetState(state) {
            Object.assign(state, null)
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
            commit('resetState')
        },

    },
    getters: {
        loader: s => s.loader
    }
}
