<template>
    <div class="history">
        <h1 class="history__title">История действий</h1>
        <div class="history__wrapper">
            <HistoryReview/>
        </div>
    </div>
</template>
<script>
import HistoryReview from '@/components/history/HistoryReview';

export default {
    name: 'History',
    components: {HistoryReview},
    data: () => ({
        checks: []
    }),
}
</script>
<style lang="scss">
.history {
    &__title {
        margin-bottom: 24px;
    }

    &__wrapper {
        padding: 24px;
        background-color: #fff;
        border-radius: 12px;
    }
}
</style>
