<template>
    <div class="user-card">
        <h3 class="user-card__item user-card__fio">{{user.user_fio}}</h3>
        <p class="user-card__item user-card__email">{{user.user_email}}</p>
        <p class="user-card__item user-card__phone">{{user.user_phone}}</p>
        <p class="user-card__item user-card__balance">Баланс: {{(user.balance ? user.balance.toFixed(2) : 0) | curr}} CFR</p>
        <p class="user-card__item user-card__count">Количество проверенных чеков: {{ (user.check_history_count ? user.check_history_count : 0) | curr}}</p>
    </div>
</template>
<script>
    export default {
        name: 'UserCard',
        props: {
            user: {
                type: Object,
                required: true,
            },
        },
    }
</script>
<style lang="scss" scoped>
    .user-card {
        margin-bottom: 20px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.07);
        border-radius: 6px;
        padding: 16px 13px;

        &:last-child {
            margin-bottom: 0;
        }

        &__item {
            margin-bottom: 5px;

            &:last-child {
                margin-bottom: 0;
            }
        }

        &__email {
            color: $primary;
        }
    }
</style>
