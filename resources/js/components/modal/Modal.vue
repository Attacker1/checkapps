<template>
        <div class="modal-mask">
            <div class="modal-wrapper">
                <slot name="default"/>
            </div>
        </div>
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
    justify-content: center;
}

.modal-wrapper {
    position: relative;
    height: calc(100% - 20px);
    width: calc(100% - 15px);
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
