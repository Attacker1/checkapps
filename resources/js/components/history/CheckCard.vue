<template>
    <div class="history-review__wrapper">
        <div class="check-card">
            <div class="check-card__left">
                <img :src="checkData.check.image" :alt="checkData.check_id" class="check-card__img">
                <div class="check-card__scale">
                    <IconZoom :size="48"/>
                </div>
            </div>
            <div class="check-card__right">
                <span class="text check-card__data">{{ checkData.created_at | moment('DD.MM.YYYY, h:mm') }}</span>
                <h3 class="text_lg check-card__status" :class="checkData.status">{{ getStatusName }}</h3>
                <span v-if="checkData.comment" class="check-card__reason">{{ checkData.comment }}</span>
            </div>
        </div>
    </div>
</template>
<script>
import IconZoom from "../../assets/icons/IconZoom";

export default {
    name: 'CheckCard',
    components: {IconZoom},
    props: {
        checkData: null,
    },
    data: () => ({
        isStatusApprove: true,
    }),
    computed: {
        getStatusName() {
            return this.checkData.status === 'REJECTED' ? 'Отклонено' : 'Одобрено';
        }
    }
}
</script>
<style lang="scss" scoped>
.check-card {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #F2F2F2;

    &:last-child {
        border-bottom: none;
    }

    &__left {
        position: relative;
        background-color: #D1D9DB;
        border-radius: 6px;
        overflow: hidden;
    }

    &__scale {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 32px;
        height: 32px;
        border-radius: 100%;
        background-color: rgba(0, 0, 0, 0.24);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    &__img {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }

    &__right {
        margin-left: 24px;
        display: flex;
        flex-direction: column;
    }

    &__data {
        color: #828282;
        margin-bottom: 12px;
        font-weight: 400;
    }

    &__status {
        margin-bottom: 4px;
        font-weight: 400;

        &.APPROVED {
            color: $success;
        }

        &.REJECTED {
            color: $rejected
        }
    }

    &__reason {
        font-weight: 400;
        color: $primary;
    }
}
</style>
