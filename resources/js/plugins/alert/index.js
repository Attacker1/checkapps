import Vue from 'vue'
import VueNoty from 'vuejs-noty'

Vue.use(VueNoty, {
    timeout: 4000,
    progressBar: false,
    animation: {
        open: 'noty_effects_open', // Animate.css class names
        close: 'noty_effects_close' // Animate.css class names
    },
})
