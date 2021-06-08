<template>
    <div class="user-card">
        <div class="user-card__left">
            <h3 class="user-card__item user-card__fio">{{user.user_fio}}</h3>
            <p class="user-card__item user-card__email">{{user.user_email}}</p>
            <p class="user-card__item user-card__phone">{{user.user_phone}}</p>
            <p class="user-card__item user-card__balance">Баланс: {{(user.balance ? user.balance.toFixed(2) : 0) |
                curr}} CFR</p>
            <p class="user-card__item user-card__count">Количество проверенных чеков: {{ (user.check_history_count ?
                user.check_history_count : 0) | curr}}</p>
        </div>
        <div class="user-card__right">
            <div class="user-card__diagram">
                <Diagram :successCount="user.check_history_count ? (user.approved_checks_count * 100 / user.check_history_count) : 100" />
                <div class="user-card__right-wrapper">
                    <div class="user-card__right-item">Подтверждено</div>
                    <div class="user-card__right-item">Отклонено</div>
                </div>
            </div>
            <div class="user-card__actions">
                <button v-if="!user.is_banned" class="button user-card__button user-card__bann" @click.prevent="block">
                    <IconBann/>
                    Заблокировать
                </button>
                <button v-if="user.is_banned" class="button user-card__button user-card__unblock" @click.prevent="unBlock">
                    <IconUnblock/>
                    Разблокировать
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import Diagram from '../diagram/Diagram';
    import IconBann from '@/assets/icons/IconBann.vue';
    import IconUnblock from '@/assets/icons/IconUnblock.vue';
    import {mapActions} from "vuex";


    export default {
        name: 'UserCard',
        components: {Diagram, IconBann, IconUnblock},
        props: {
            user: {
                type: Object,
                required: true,
            },
        },

        methods: {
            ...mapActions({
                blockUser: 'admin/blockUser',
                unblockUser: 'admin/unblockUser',
            }),

            block() {
                this.blockUser(this.user.user_id)
            },

            unBlock() {
                this.unblockUser(this.user.user_id);
            }
        }
    }
</script>
<style lang="scss" scoped>
    .user-card {
        margin-bottom: 20px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.07);
        border-radius: 6px;
        padding: 16px 13px;
        display: flex;
        justify-content: space-between;
        width: 100%;

        @media screen and (max-width: 767px) {
            flex-direction: column;
        }

        &__left {
            display: flex;
            flex-direction: column;

            @media screen and (max-width: 1023px) {
                justify-content: center;
            }

            @media screen and (max-width: 767px) {
                align-items: center;
            }

            @media screen and (max-width: 480px) {
                text-align: center;
            }
        }

        &__right {
            margin-left: 20px;
            display: flex;

            @media screen and (max-width: 1023px) {
                flex-direction: column;
            }

            @media screen and (max-width: 767px) {
                margin-left: 0;
                align-items: center;
                margin-top: 20px;
            }

            &-wrapper {
                display: flex;
                flex-direction: column;
                justify-content: center;
                margin-left: 20px;

                @media screen and (max-width: 480px) {
                    margin-left: 10px;
                }
            }

            &-item {
                margin-bottom: 10px;
                position: relative;
                padding-left: 20px;

                @media screen and (max-width: 480px) {
                    font-size: 14px;
                }

                &:before {
                    content: "";
                    width: 10px;
                    height: 10px;
                    min-width: 10px;
                    border: 1px solid #bdbdbd;
                    background-color: #ee5a2b;
                    position: absolute;
                    left: 0;
                    top: 50%;
                    transform: translateY(-50%);
                }

                &:first-child {
                    &:before {
                        background-color: #0071e3;
                    }
                }
            }
        }

        &__diagram {
            display: flex;

            @media screen and (max-width: 1023px) {
                align-items: center;
            }
        }

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

        &__actions {
            display: flex;
            align-items: center;
            margin-left: 20px;

            @media screen and (max-width: 1023px) {
                margin-left: 0;
            }

            @media screen and (max-width: 767px) {
                margin-top: 20px;
            }
        }

        &__button {
            border-radius: 5px;
            display: flex;
            align-items: center;
            font-size: 16px;
            transition: 0.2s background-color;
            min-width: 203px;

            svg {
                margin-right: 5px;
                transition: 0.2s fill;
            }

            @media screen and (max-width: 1023px) {
                opacity: 1;
            }

            @media screen and (max-width: 480px) {
                font-size: 16px;
            }
        }

        &__bann {
            background-color: #ff6243;
            color: #fff;

            &:hover {
                background-color: #e5563a;
            }
        }

        &__unblock {
            background-color: deepskyblue;
            color: #fff;

            &:hover {
                background-color: #00abe5;
            }
        }
    }
</style>
