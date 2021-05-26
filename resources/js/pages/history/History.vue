<template>
    <div class="history">
        <div class="history__wrapper">
            <h2 class="history__title">Баланс</h2>
            <div class="title_md history__balance-count">{{(user.balance ? user.balance : 0) | curr}} CFR</div>
        </div>
        <div class="history__wrapper">
            <h2 class="history__title">История действий</h2>
            <HistoryReview class="history__review"/>
        </div>
    </div>
</template>
<script>
import HistoryReview from '@/components/history/HistoryReview';
import {mapGetters} from "vuex";

export default {
    name: 'History',
    components: {HistoryReview},
    computed: {
        ...mapGetters('auth', ['user']),
    },
    data: () => ({
        checks: []
    }),
}
</script>
<style lang="scss" scoped>
.history {
    &__balance {
        &-count {
            font-weight: 600;
        }
    }

    &__title {
        font-weight: 500;
        margin-bottom: 16px;
    }

    &__wrapper {
        padding: 24px;
        background-color: #fff;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    &__review {
        margin-top: 24px;
    }
}
</style>
