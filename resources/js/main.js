import Vue from 'vue';
import router from "./router";
import store from "./store"
import plugins from './plugins'
import App from "./App";
import './filters'

new Vue({
    el: '#app',
    store: store,
    router: router,
    ...plugins,
    render: h => h(App)
});
