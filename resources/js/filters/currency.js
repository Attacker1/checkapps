import Vue from 'vue';

Vue.filter('curr', (v) => {
    return v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
