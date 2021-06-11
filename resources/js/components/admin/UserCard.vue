<template>
    <div class="user-card">
        <div class="user-card__wrapper">
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
                    <Diagram
                        :successCount="user.check_history_count ? (user.approved_checks_count * 100 / user.check_history_count) : 100"/>
                    <div class="user-card__right-wrapper">
                        <div class="user-card__right-item">({{ user.approved_checks_count }})Подтверждено</div>
                        <div class="user-card__right-item">({{ user.rejected_checks_count }})Отклонено</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-card__bottom">
            <button class="button user-card__button user-card__unblock"
                    @click.prevent="showPermissions">
                {{ allPermissions.length === 0 ? 'Установить права' : 'Скрыть права' }}
            </button>
            <div class="user-card__actions">
                <button v-if="!user.is_banned" class="button user-card__button user-card__bann"
                        @click.prevent="block">
                    <IconBann/>
                    Заблокировать
                </button>
                <button v-if="user.is_banned" class="button user-card__button user-card__unblock"
                        @click.prevent="unBlock">
                    <IconUnblock/>
                    Разблокировать
                </button>
            </div>
        </div>
        <div class="user-card__select" v-if="allPermissions.length">
            <multiselect v-model="currentPermissions" tag-placeholder="Add this as new tag"
                         placeholder="Search or add a tag"
                         :close-on-select="false" :clear-on-select="false"
                         label="name" track-by="slug" :options="allPermissions" :multiple="true"
                         :taggable="true">
            </multiselect>
            <button class="button user-card__button user-card__unblock user-card__update"
                    @click.prevent="updatePermissions">
                Обновить
            </button>
        </div>
    </div>
</template>
<script>
    import Diagram from '../diagram/Diagram';
    import IconBann from '@/assets/icons/IconBann.vue';
    import IconUnblock from '@/assets/icons/IconUnblock.vue';
    import {mapActions} from "vuex";
    import Multiselect from 'vue-multiselect';
    import axios from 'axios';
    import Vue from 'vue';


    export default {
        name: 'UserCard',
        components: {Diagram, IconBann, IconUnblock, Multiselect},
        props: {
            user: {
                type: Object,
                required: true,
            },
        },
        data: () => ({
            currentPermissions: [],
            allPermissions: []
        }),

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
            },

            async showPermissions() {
                if (this.allPermissions.length === 0) {
                    try {
                        const responseAllPermissions = await axios.get('permissions');
                        this.allPermissions = responseAllPermissions.data;
                        const responseCurrentPermissions = await axios.get(`users/${this.user.user_id}`);
                        this.currentPermissions = responseCurrentPermissions.data.permissions;
                    } catch (response) {
                        console.log(response);
                    }
                } else {
                    this.allPermissions = [];
                    this.currentPermissions = [];
                }
            },

             async updatePermissions() {
                try {
                    let data = {
                        user_id: this.user.user_id,
                        permissions: this.currentPermissions.map((el) => {
                            return el.slug;
                        })
                    }
                    const response = await axios.post('users/manage-permissions', data);
                    Vue.noty.success(response.data.message);
                } catch (response) {
                    console.log(response);
                }
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
        width: 100%;

        @media screen and (max-width: 767px) {
            flex-direction: column;
        }

        &__wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            width: 100%;

            @media screen and (max-width: 767px) {
                grid-template-columns: 1fr;
            }
        }

        &__bottom {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;

            @media screen and (max-width: 767px) {
                justify-content: center;
            }

            @media screen and (max-width: 767px) {
                flex-direction: column;
                align-items: center;
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
            display: flex;
            flex-direction: column;

            @media screen and (max-width: 767px) {
                margin-left: 0;
                align-items: center;
                margin-top: 20px;
            }

            &-wrapper {
                display: flex;
                flex-direction: column;
                justify-content: center;
                margin-left: 16px;

                @media screen and (max-width: 480px) {
                    margin-left: 0;
                    margin-top: 16px;
                }
            }

            &-item {
                margin-bottom: 10px;
                position: relative;
                padding-left: 20px;
                font-size: 15px;

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
            justify-content: center;

            @media screen and (max-width: 1023px) {
                align-items: center;
            }

            @media screen and (max-width: 480px) {
                flex-direction: column;
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
            justify-content: flex-end;
            margin-left: 16px;

            @media screen and (max-width: 767px) {
                margin-left: 0;
                margin-top: 16px;
            }
        }

        &__button {
            border-radius: 5px;
            display: flex;
            align-items: center;
            font-size: 16px;
            transition: 0.2s background-color;
            padding: 10px 15px;

            svg {
                margin-right: 5px;
                transition: 0.2s fill;
                width: 15px;
                height: 15px;
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

        &__select {
            width: 100%;
            margin-top: 20px;
        }

        &__update {
            margin-top: 16px;

            @media screen and (max-width: 767px) {
                margin-left: auto;
                margin-right: auto;
            }
        }
    }
</style>
