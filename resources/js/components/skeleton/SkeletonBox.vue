<template>
    <span :style="{ height, width, borderRadius }" class="SkeletonBox">
        <slot/>
    </span>
</template>

<script>

export default {
    name: 'SceletonBox',
    props: {
        maxWidth: {
            type: Number,
            default: 100
        },
        minWidth: {
            type: Number,
            default: 80
        },
        height: {
            type: String,
            default: '1em'
        },
        width: {
            type: String,
            default: '1em'
        },
        borderRadius: {
            type: String,
            default: '0px'
        }
    },
    methods: {
        computedWidth() {
            return this.width || `${Math.floor((Math.random() * (this.maxWidth - this.minWidth)) + this.minWidth)}%`;
        }
    },
}
</script>

<style lang="scss" scoped>
.SkeletonBox {
    display: inline-block;
    position: relative;
    vertical-align: middle;
    overflow: hidden;
    background-color: rgba(0, 0, 0, 0.12);

    &::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        transform: translateX(-100%);
        background-image: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0,
                rgba(255, 255, 255, 0.2) 20%,
                rgba(255, 255, 255, 0.5) 60%,
                rgba(255, 255, 255, 0)
        );
        animation: shimmer 2000ms infinite;
        content: '';
    }

    @keyframes shimmer {
        100% {
            transform: translateX(100%);
        }
    }
}
</style>
