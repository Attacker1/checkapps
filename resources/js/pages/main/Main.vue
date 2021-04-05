<template>
    <div>
        <CheckView/>
    </div>
</template>

<script>
import CheckView from '@/components/check/CheckView';
import {mapActions} from 'vuex';

export default {
    name: 'Main',
    components: {CheckView},
    methods: {
        ...mapActions({
            'checkExpiryDate': 'checks/checkExpiryTime'
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
