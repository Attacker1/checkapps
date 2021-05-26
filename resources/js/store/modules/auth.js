import Vue from 'vue';

export default {
    namespaced: true,
    state() {
        return {};
    },

    actions: {
        fetch(ctx) {
            return Vue.auth.fetch().catch((e) => {
                if (e.response.status === 401) {
                    ctx.dispatch('logout');
                }
            });
        },

        refresh(data) {
            return Vue.auth.refresh(data);
        },

        login(ctx, data) {
            data = data || {};
            return Vue.auth.login({
                data: data.body,
                fetchUser: true,
                staySignedIn: true,
            }).then((res) => {
                Vue.router.push({name: 'Main'});
                return res;
            });
        },

        logout() {
            /* reset localStorage */
            localStorage.clear();
            return Vue.auth.logout({redirect: {name: 'Login'}});
        },
    },

    getters: {
        user() {
            return Vue.auth.user();
        },
    }
}
