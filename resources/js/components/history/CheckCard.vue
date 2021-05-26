<template>
    <div class="check-card">
        <div class="check-card__left">
            <img src="" alt="check" class="check-card__img">
            <div class="check-card__scale">
                <IconZoom :size="48"/>
            </div>
        </div>
        <div class="check-card__right">
            <span class="text check-card__data">22.08.2020, 17:27</span>
            <h3 class="text_lg check-card__status" :class="isStatusApprove ? 'approve' : 'rejected'">{{ isStatusApprove ? 'Одобрено' : 'Отклонено' }}</h3>
            <span class="check-card__reason">Причина 2</span>
        </div>
    </div>
</template>
<script>
import IconZoom from "../../assets/icons/IconZoom";
export default {
    name: 'CheckCard',
    components: {IconZoom},
    data: () => ({
        isStatusApprove: true,
    }),
}
</script>
<style lang="scss">
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
        font-weight: 500;
    }

    &__status {
        margin-bottom: 4px;
        font-weight: 500;

        &.approve {
            color: $success;
        }

        &.rejected {
            color: $rejected
        }
    }

    &__reason {
        font-weight: 500;
    }
}
</style>
