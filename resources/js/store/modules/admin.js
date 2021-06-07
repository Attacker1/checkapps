import axios from 'axios';
import Vue from 'vue';

export default {
    namespaced: true,
    state: {
        users: [],
    },

    mutations: {
        setUsers: (state, payload) => {
            state.users = payload;
        },

        removeUsers: (state) => {
            state.users = [];
        },
    },

    actions: {
        async fetchUsers({commit, state}, params = {paginate: 10, page: 1}) {

            commit('common/setLoader', null, {root: true})

            try {
                const response = await axios.get('users', {params});
                commit('setUsers', response.data);
            } catch (response) {
                console.log(response)
            }
            commit('common/removeLoader', null, {root: true})
        },

        async resetAllUsers({commit}) {
            commit('removeUsers');
        },
    },
    getters: {
        users: s => s.users
    }
}
