<template>
    <div class="user-list">
        <div class="user-list__wrapper">
            <UserCard v-if="users.data" v-for="user in users.data" :key="user.id" :user="user"/>
        </div>
        <Pagination @change-page="changePage" v-if="users.data" :links="links"/>
    </div>
</template>
<script>
    import {mapActions, mapGetters} from 'vuex';
    import UserCard from '@/components/admin/UserCard';
    import Pagination from '@/components/pagination/Pagination';
    import axios from 'axios';

    export default {
        name: 'UserList',
        components: {UserCard, Pagination},

        computed: {
            ...mapGetters({
                loader: 'common/loader',
                users: 'admin/users'
            })
        },

        data: () => ({
            links: [],
            currentPage: 1,
            lastPage: {
                Type: Number,
            }
        }),

        methods: {
            ...mapActions({
                fetchUsers: 'admin/fetchUsers',
                resetUsers: 'admin/resetAllUsers',
            }),

            async getUsers() {
                this.$store.commit('common/setLoader', null, {root: true})
                try {
                    const response = await axios.get('users', {
                        params: {
                            paginate: 10,
                            page: this.currentPage,
                        }
                    })
                    this.users = response.data.data;
                    this.links = response.data.links;
                    this.lastPage = response.data.last_page;
                    this.currentPage = response.data.current_page;
                } catch (response) {
                    console.log(response)
                }
                this.$store.commit('common/removeLoader', null, {root: true})
            },

            changePage(val) {
                if (val.link.url) {
                    const url = new URL(val.link.url);
                    url.searchParams.has('page') ? this.currentPage = url.searchParams.get('page') : '';
                    let params = {
                        paginate: 10,
                        page: this.currentPage
                    }
                    url.searchParams.has('filter') ? params['filter'] = url.searchParams.get('filter') : '';
                    url.searchParams.has('searchBy') ? params['searchBy'] = url.searchParams.get('searchBy') : '';
                    url.searchParams.has('s') ? params['s'] = url.searchParams.get('s') : '';
                    this.fetchUsers(params);
                    this.links = this.users.links;
                }
            }
        },

        async beforeMount() {
            await this.fetchUsers();
            this.links = this.users.links;
            this.currentPage = this.users.current_page;
            this.lastPage = this.users.last_page;
        }
    }
</script>
<style lang="scss" scoped>
</style>
