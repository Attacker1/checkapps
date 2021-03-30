export default {
    namespaced: true,
    state: {
        windowSize: null,
        loader: false,
    },

    mutations: {
        setLoader: (state) => {
            state.loader = true
        },
        removeLoader: (state) => {
            state.loader = false
        }
    },

    actions: {
        loaderOn({commit}) {
            commit('setLoader');
        },
        loaderOff({commit}) {
            commit('removeLoader');
        }
    },
    getters: {
        loader: s => s.loader
    }
}
