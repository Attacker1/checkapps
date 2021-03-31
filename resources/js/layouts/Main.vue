<template>
    <div class="wrap">
        <Header/>
        <div class="content">
            <div class="container">
                <flash-message class="flash-main"></flash-message>
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
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    .content {
        width: 100%;

        @media screen and (max-width: 767px) {
            margin-top: 80px;
            margin-bottom: 50px;
        }
    }
</style>
