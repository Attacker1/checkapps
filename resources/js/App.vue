<template>
    <div class="main">
        <router-view/>
    </div>
</template>

<script>

    export default {
        name: 'App',
    };
</script>
<style lang="scss">
    @import '@/assets/styles/main.scss';

    .main {
        background-color: $bg;
    }
</style>
