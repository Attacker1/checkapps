import Vue from 'vue'
import moment from "moment";
import VueMoment from "vue-moment";

require('moment/locale/ru');
Vue.use(VueMoment, {moment: moment});


export default {};
