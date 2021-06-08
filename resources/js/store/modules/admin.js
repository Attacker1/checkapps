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

        setBlock: (state, payload) => {
            let us = state.users.data.find(item => item.user_id === payload.id);
            us.is_banned = payload.isBlocked;
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
            } catch (error) {
                Vue.noty.error(error.response.data.error);
            }
            commit('common/removeLoader', null, {root: true})
        },

        async blockUser({commit}, id) {
            try {
                await axios.get(`users/${id}/block`);
                commit('setBlock', {id: id, isBlocked: true});
                Vue.noty.success('Пользователь заблокирован');
            } catch (error) {
                // console.log(Object.keys(response));
                Vue.noty.error(error.response.data.error);
            }
        },

        async unblockUser({commit}, id) {
            try {
                await axios.get(`users/${id}/unblock`);
                commit('setBlock', {id: id, isBlocked: false});
                Vue.noty.success('Пользователь разблокирован');
            } catch (error) {
                Vue.noty.error(error.response.data.error);
            }
        },

        async resetAllUsers({commit}) {
            commit('removeUsers');
        },
    },
    getters: {
        users: s => s.users
    }
}
