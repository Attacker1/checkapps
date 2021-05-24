<template>
    <div class="history-review">
        <h2 class="mb-12 text_lg history-review__title">21 Августа</h2>
        <div class="history-review__wrapper">
            <CheckCard  />
            <CheckCard  />
            <CheckCard  />
        </div>
    </div>
</template>
<script>
import CheckCard from "./CheckCard";

export default {
    name: 'HistoryReview',
    components: {CheckCard}
}
</script>
<style lang="scss">
.history-review {
}
</style>
