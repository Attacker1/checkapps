import {getStorageItem, setStorageItem, removeStorageItem} from "@/utils/localStorage";
import axios from 'axios';

export default {
    namespaced: true,
    state: {
        currentCheck: getStorageItem('currentCheck'),
    },

    mutations: {
        setCurrentCheck: (state, payload) => {
            setStorageItem('currentCheck', state, payload ? payload : null);
        },
        resetCurrentCheck: (state) => {
            removeStorageItem('currentCheck', state);
        }
    },

    actions: {
        removeFromChecks({state, rootGetters, commit, dispatch}) {
            const checks = rootGetters['checks/checks'];

            const filteredChecks = checks.filter((check) => {
                return check.check_id !== state.currentCheck.check_id
            })


            if (filteredChecks.length > 0) {
                commit('checks/setChecks', filteredChecks, {root: true});
                commit('resetCurrentCheck');
                commit('setCurrentCheck', filteredChecks[0])

            } else {
                dispatch('checks/fetchChecks', null, {root: true})
            }
            dispatch('auth/fetch', null, {root: true});
        }
    },

    getters: {
        currentCheck: state => state.currentCheck,
    }
}
