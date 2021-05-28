<template>
    <div class="skeleton-card">
        <SkeletonBox height="100px" width="100px" border-radius="6px" class="skeleton-card__left"/>
        <SkeletonBox class="skeleton-stage__right" height="100px" border-radius="6px" width="100%"/>
        <slot/>
    </div>
</template>

<script>
    import SkeletonBox from '@/components/skeleton/SkeletonBox';

    export default {
        name: 'CheckHistoryCard',
        components: {
            SkeletonBox
        }
    }
</script>
<style lang="scss" scoped>
    .skeleton-card {
        display: flex;
        margin-bottom: 24px;

        &:last-child {
            margin-bottom: 0;
        }

        &__left {
            min-width: 100px;
            margin-right: 24px;
        }
    }
</style>
