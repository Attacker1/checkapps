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
                <Diagram :successCount="50" />
                <div class="user-card__right-wrapper">
                    <div class="user-card__right-item">Подтверждено</div>
                    <div class="user-card__right-item">Отклонено</div>
                </div>
            </div>
            <div class="user-card__actions">
                <button v-if="user.is_banned === 0" class="button user-card__button user-card__bann" @click.prevent="block">
                    <IconBann/>
                    Деклассировать
                </button>
                <button v-if="user.is_banned === 1" class="button user-card__button user-card__unblock" @click.prevent="unBlock">
                    <IconUnblock/>
                    Отпустить грехи
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

        &:hover {
            .user-card__button {
                opacity: 1;
            }
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
            font-size: 20px;
            transition: 0.2s all;
            min-width: 250px;
            opacity: 0;

            @media screen and (max-width: 1023px) {
                opacity: 1;
            }

            @media screen and (max-width: 480px) {
                font-size: 16px;
            }
        }

        &__bann {
            background-color: #c00;
            color: #fff;

            svg {
                margin-right: 5px;
                transition: 0.2s background-color;
            }

            &:hover {
                background-color: #af0000;

                svg {
                    background-color: #af0000;
                }
            }
        }

        &__unblock {
            background-image: linear-gradient(160deg, #a54e07, #b47e11, #fef1a2, #bc881b, #a54e07);
            background-size: 100% 100%;
            background-position: center;
            color: rgb(120, 50, 5);
            border: 1px solid #a55d07;
            transition: all 0.2s ease-in-out;

            svg {
                margin-right: 5px;
            }

            &:hover {
                background-size: 150% 150%;
            }
        }
    }
</style>
