<template>
    <div class="loader">
        <div class="fulfilling-bouncing-circle-spinner">
            <div class="circle"></div>
            <div class="orbit"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Loader"
    }
</script>

<style lang="scss" scoped>
    .loader {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        background-color: rgba(white, 0.5);
    }
</style>
