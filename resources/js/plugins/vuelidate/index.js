import Vue from 'vue';

import Vuelidate from 'vuelidate';
import VuelidateErrorExtractor from 'vuelidate-error-extractor';
import messages from '@/plugins/vuelidate/messages';

Vue.use(Vuelidate);
Vue.use(VuelidateErrorExtractor, {
    i18n: false,
    messages: messages.validation,
});

