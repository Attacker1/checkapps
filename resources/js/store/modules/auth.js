import axios from 'axios';
import {apiConfig} from '@/utils/api/';

export default {
    namespaced: true,
    state: {
        user: null,
        token_id: null
    },

    mutations: {
        setUser: (state, payload) => {
            this.user = payload
        },
        setUserToken: (state, payload) => {
            this.token_id = payload
        },
        logOut: (state) => {
            state.user = null
            state.token_id = null
        }
    },

    actions: {
        async LogIn({commit}, User) {
            const response = await axios(apiConfig('User/login', User))
                .then(res => {
                    console.log(res)
                    return JSON.parse(res.data);
                })
                .catch((error) => console.log(error))

            await commit('setUser', response.result.info)
            await commit('setUserToken', response.result.token_id)
        },

        async LogOut({commit}) {
            commit('logOut')
        }
    },

    getters: {
        auth: state => !!state.user,
        token_id: state => state.token_id,
        user: state => state.user,
    }
}
