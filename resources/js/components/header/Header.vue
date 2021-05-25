<template>
    <header class="header">
        <div class="container d-flex align-center justify-between">
            <div class="d-flex align-center">
                <IconProfile class="mr-20"/>
                <div v-if="user">
                    <p class="text text_bold">{{ user.user_fio }}</p>
                    <p class="text_sm text_grey">{{ user.user_email }}</p>
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
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    padding-top: 30px;

    @media screen and (max-width: 767px) {
        padding-top: 20px;
    }
}

.logout-link {
    transition: color ease 200ms;

    &:hover {
        color: $primary;
    }
}
</style>
