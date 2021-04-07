<template>
    <transition name="fade">
        <div class="modal-mask">
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
        position: absolute;
        z-index: 999;
        top: 500px;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;

        &.active {
            @media screen and (min-width: 1024px) {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
                top: 0;
            }
        }

        @media screen and (max-width: 1023px) {
            position: fixed;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            top: 0;
        }
    }

    .modal-wrapper {
        position: relative;
        height: 100%;
        width: calc(100% - 15px);
        display: flex;
        align-items: center;
        justify-content: center;

        @media screen and (max-width: 1023px) {
            height: calc(100% - 20px);
        }
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
