import Vue from 'vue';
import VueFlashMessage from 'vue-flash-message';

Vue.use(VueFlashMessage, {
    messageOptions: {
        timeout: 2000,
        important: true,
        autoEmit: false,
        pauseOnInteract: true
    }
});
