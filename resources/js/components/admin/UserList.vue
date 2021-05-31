<template>
    <div class="user-list">
        {{users}}
    </div>
</template>
<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        name: 'UserList',

        methods: {
            ...mapActions({
                'fetchUsers': 'admin/fetchUsers',
            })
        },
        computed: {
            ...mapGetters({
                users: 'admin/users',
                loader: 'common/loader'
            })
        },
        async beforeMount() {
            /*await this.$recaptchaLoaded()
            const token = await this.$recaptcha('check')*/
            this.fetchUsers();
        },
    }
</script>
<style lang="scss" scoped>
</style>
