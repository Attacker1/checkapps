<template>
    <header class="header">
        <div class="container d-flex align-center justify-between">
            <div class="d-flex align-center">
                <div class="d-flex align-center">
                    <div @click="goToMain" class="header__profile">
                        <IconProfile class="mr-20"/>
                    </div>
                    <div v-if="user" class="user-fio">
                        <p class="text text_bold">{{ user.user_fio }}</p>
                        <p class="text_sm text_grey">{{ user.user_email }}</p>
                    </div>
                </div>
                <div class="d-flex flex-column ml-50 header__balance">
                    <p class="text text_bold">{{ (user.balance ? user.balance : 0) | curr }} CFR</p>
                    <p class="text_sm text_grey">баланс</p>
                </div>
            </div>
            <div class="header__links">
                <div @click="goToProfile" class="text_pointer text_decornone logout-link text_grey text_md header__link">История</div>
                <div @click="submitLogout" class="text_pointer text_decornone logout-link text_grey text_md header__link">Выйти</div>
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

            goToProfile() {
                Vue.router.push({name: 'History'}).catch(err => {});
            },

            goToMain() {
                Vue.router.push({name: 'Main'}).catch(err => {});
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

    .logout-link {
        transition: color ease 200ms;

        &:hover {
            color: $primary;
        }
    }
</style>
