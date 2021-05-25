<template>
    <div>
        <CheckViewSkeleton v-if="loader"/>
        <CheckView v-else/>
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
            'checkExpiryDate': 'checks/checkExpiryTime'
        })
    },
    computed: {
        ...mapGetters({
            check: 'currentCheck/currentCheck',
            loader: 'common/loader'
        })
    },
    mounted() {
        setInterval(() => {
            this.checkExpiryDate();
        }, 1000)
    }
}
</script>

<style scoped>

</style>
