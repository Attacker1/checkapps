<template>
    <transition name="fade">
        <div class="modal-mask" @click="$emit('close')">
            <div class="modal-wrapper">
                <slot name="default"/>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "Modal"
    }
</script>

<style lang="scss" scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-items: center;
    }

    .modal-enter-active, .modal-leave-active {
        transition: opacity .5s;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

    .fade-enter-to {
        opacity: 1;
    }
</style>
