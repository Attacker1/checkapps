<template>
    <div class="wrap">
        <Header/>
        <div class="content">
            <div class="container">
                <router-view/>
            </div>
        </div>
    </div>
</template>

<script>
    import Header from '@/components/header/Header';

    export default {
        name: 'MainLayout',
        components: {Header}
    }
</script>

<style lang="scss" scoped>
    .wrap {
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 82px);
    }

    .content {
        width: 100%;
        margin-top: 12px;
    }
</style>
