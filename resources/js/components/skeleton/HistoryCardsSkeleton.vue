<template>
    <div class="skeleton-history">
        <CheckHistoryCard v-for="index in 10" :key="index" />
    </div>
</template>

<script>
    import SkeletonBox from '@/components/skeleton/SkeletonBox';
    import CheckHistoryCard from '@/components/skeleton/CheckHistoryCard';

    export default {
        name: 'HistoryCardsSkeleton',
        components: {
            SkeletonBox,
            CheckHistoryCard
        }
    }
</script>
<style lang="scss" scoped>
    .skeleton-history {
        width: 100%;
        display: flex;
        flex-direction: column;
    }
</style>
