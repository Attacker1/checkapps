<template>
    <div class="skeleton-check">
        <SkeletonBox height="600px" width="100%" border-radius="6px" class="skeleton-check__left"/>
        <SkeletonBox class="skeleton-stage__right" height="600px" border-radius="6px" width="100%"/>
        <slot/>
    </div>
</template>

<script>
    import SkeletonBox from '@/components/skeleton/SkeletonBox';

    export default {
        name: 'CheckViewSkeleton',
        components: {
            SkeletonBox
        }
    }
</script>
<style lang="scss">
    .skeleton-check {
        position: relative;
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        grid-gap: 24px;
        grid-template-rows: 600px;

        @media screen and (max-width: 767px) {
            grid-template-columns: 1fr;
        }
    }
</style>
