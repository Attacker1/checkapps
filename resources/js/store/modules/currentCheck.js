import {getStorageItem, setStorageItem, removeStorageItem} from "@/utils/localStorage";

export default {
    namespaced: true,
    state: {
        currentCheck: getStorageItem('currentCheck'),
    },

    mutations: {
        setCurrentCheck: (state, payload) => {
            setStorageItem('currentCheck', state, payload);
        },
        resetCurrentCheck: (state) => {
            removeStorageItem('currentCheck', state);
        }
    },

    actions: {
        removeFromChecks({state, rootGetters, commit, dispatch}) {
            const checks = rootGetters['checks/checks'];

            const filteredChecks = checks.filter((check) => {
                return check.id !== state.currentCheck.id
            })

            console.log(filteredChecks);

            if (filteredChecks.length) {
                commit('checks/setChecks', filteredChecks, {root: true});
                commit('resetCurrentCheck');
                commit('setCurrentCheck', filteredChecks[0])
            } else {
                dispatch('checks/fetchChecks', null, {root: true})
            }
        }
    },

    getters: {
        currentCheck: state => state.currentCheck,
    }
}
