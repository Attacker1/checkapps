import Vue from 'vue'
import VueNoty from 'vuejs-noty'

Vue.use(VueNoty, {
    timeout: 4000,
    progressBar: true,
    layout: 'topCenter',
})
