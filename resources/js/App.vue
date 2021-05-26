<template>
    <div class="main" v-resize="onResize" >
        <router-view/>
    </div>
</template>

<script>
import {Component, Vue} from 'vue-property-decorator';

    import {mapActions} from 'vuex';
    import resize from 'vue-resize-directive'

    export default {
        name: 'App',
        directives: {
            resize,
        },
        methods: {
            ...mapActions({
                windowSize: 'common/windowSize',
            }),
            onResize() {
                this.windowSize(window.innerWidth)
            },
        },
        mounted() {
            this.onResize();
        },
    };

</script>
<style lang="scss">
@import '@/assets/styles/main.scss';

.main {
    background-color: $bg;
    min-height: 100vh;
}
</style>
