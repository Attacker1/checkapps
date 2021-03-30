import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

import common from '@/store/modules/common';
import auth from '@/store/modules/auth';
import check from '@/store/modules/check';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        auth,
        common,
        check,
    },
    plugins: [createPersistedState()],
    strict: debug
});
