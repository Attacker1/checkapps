<template>
    <header class="header">
        <div class="container d-flex align-center justify-between">
            <div class="d-flex align-center">
                <div class="d-flex align-center">
                    <router-link :to="{name: 'History'}">
                        <IconProfile class="mr-20"/>
                    </router-link>
                    <div v-if="user" class="user-fio">
                        <p class="text text_bold">{{ user.user_fio }}</p>
                        <p class="text_sm text_grey">{{ user.user_email }}</p>
                    </div>
                </div>
                <div class="d-flex flex-column ml-50 header__balance">
                    <p class="text text_bold">{{(user.balance ? user.balance : 0) | curr}} CFR</p>
                    <p class="text_sm text_grey">баланс</p>
                </div>
            </div>
            <div>
                <div @click="submitLogout" class="text_pointer text_decornone logout-link text_grey text_md">Выйти</div>
            </div>
        </div>
    </header>
</template>

<script>
    import IconProfile from '@/assets/icons/IconProfile';
    import {mapGetters} from "vuex";

    export default {
        name: 'Header',
        components: {IconProfile},
        computed: {
            ...mapGetters('auth', ['user']),
        },

        methods: {
            submitLogout() {
                this.$store.dispatch('auth/logout')
            }
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

        &__balance {
            @media screen and (max-width: 767px) {
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
