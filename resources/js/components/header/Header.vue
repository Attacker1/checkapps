<template>
    <header class="header">
        <div class="container d-flex align-center justify-between">
            <div class="d-flex align-center">
                <div class="d-flex align-center">
                    <router-link :to="{name: 'Main'}" class="header__profile">
                        <IconProfile class="mr-20"/>
                    </router-link>
                    <div v-if="user" class="user-fio">
                        <p class="text text_bold">{{ user.user_fio }}</p>
                        <p class="text_sm text_grey">{{ user.user_email }}</p>
                    </div>
                </div>
                <div v-if="!user.is_admin" class="d-flex flex-column ml-50 header__balance">
                    <p class="text text_bold">{{ (user.balance ? user.balance : 0) | curr }} CFR</p>
                    <p class="text_sm text_grey">баланс</p>
                </div>
            </div>
            <div class="header__links">
                <router-link v-if="!user.is_admin" :to="{name: 'History'}" class="text_pointer text_decornone text_grey text_md header__link">История</router-link>
                <router-link v-if="user.is_admin" :to="{name: 'Settings'}" class="text_pointer text_decornone text_grey text_md header__link">Настройки</router-link>
                <div @click="submitLogout" class="text_pointer text_decornone text_grey text_md header__link">Выйти</div>
            </div>
        </div>
    </header>
</template>

<script>
    import IconProfile from '@/assets/icons/IconProfile';
    import {mapGetters} from "vuex";
    import Vue from "vue";

    export default {
        name: 'Header',
        components: {IconProfile},
        computed: {
            ...mapGetters('auth', ['user']),
        },

        methods: {
            async submitLogout() {
                await this.$store.dispatch('checks/resetAllChecks');
                await this.$store.dispatch('currentCheck/resetCurrentCheck');
                await this.$store.dispatch('auth/logout');
            },
        },
    }
</script>

<style lang="scss" scoped>
    .header {
        width: 100%;
        padding: 30px 0;

        @media screen and (max-width: 767px) {
            padding-top: 20px;
        }

        &__profile {
            cursor: pointer;
        }

        &__balance {
            @media screen and (max-width: 767px) {
                margin-left: 0;
            }
        }

        &__links {
            display: flex;
            align-items: center;
        }

        &__link {
            margin-left: 50px;
            transition: color ease 200ms;

            &:hover {
                color: $primary;
            }

            @media screen and (max-width: 480px) {
                margin-left: 30px;
            }

            &:first-child {
                margin-left: 0;
            }
        }
    }

    .user-fio {
        @media screen and (max-width: 767px) {
            display: none;
        }
    }
</style>
