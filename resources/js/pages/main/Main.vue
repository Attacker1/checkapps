<template>
    <div class="main-page">
        <CheckViewSkeleton v-if="loader"/>
        <CheckView v-if="!loader && check"/>
        <h1 class="main-page__notfound" v-if="!check">Чеков нет, но вы держитесь</h1>
    </div>
</template>

<script>
import CheckView from '@/components/check/CheckView';
import CheckViewSkeleton from '@/components/skeleton/CheckViewSkeleton';
import {mapActions, mapGetters} from 'vuex';

export default {
    name: 'Main',
    components: {CheckView, CheckViewSkeleton},
    methods: {
        ...mapActions({
            'checkExpiryDate': 'checks/checkExpiryTime',
            'fetchChecks': 'checks/fetchChecks',
        })
    },
    computed: {
        ...mapGetters({
            check: 'currentCheck/currentCheck',
            loader: 'common/loader'
        })
    },
    async beforeMount() {
        await this.$recaptchaLoaded()

        const token = await this.$recaptcha('check')
        // console.log(token);
        this.fetchChecks({recaptcha_token: token})
    },
    mounted() {
        setInterval(() => {
            this.checkExpiryDate();
        }, 1000)
    }
}
</script>

<style lang="scss" scoped>
.main-page {
    min-height: calc(100vh - 91px);
    display: flex;
    align-items: center;

    &__notfound {
        text-align: center;
        width: 100%;
        font-size: 72px;

        @media screen and (max-width: 767px) {
            font-size: 40px;
        }
    }
}
</style>
