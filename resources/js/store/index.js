import Vue from 'vue';
import Vuex from 'vuex';

import common from '@/store/modules/common';
import auth from '@/store/modules/auth';
import currentCheck from '@/store/modules/currentCheck';
import checks from '@/store/modules/checks';
import checkActions from '@/store/modules/checkActions';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        auth,
        common,
        checks,
        currentCheck,
        checkActions,
    },
    strict: debug
});
