<template>
    <div class="notfound">
        <Banner />
    </div>
</template>
<script>
    import Banner from '@/components/notfound/Banner.vue';

    export default {
        components: {Banner},

        mounted() {
            this.$router.push({
                path: '/404'
            }).catch(err => {});
        }
    }
</script>
<style lang="scss" scoped>
    .notfound {
        min-height: calc(100vh - 91px);
        display: flex;
        align-items: center;
    }
</style>
