<template>
    <div class="admin-panel">
        <div class="admin-panel__wrapper">
            <FindUsers/>
            <UserList />
        </div>
    </div>
</template>
<script>
    import FindUsers from '@/components/admin/FindUsers';
    import UserList from '@/components/admin/UserList';

    export default {
        name: 'Admin',
        components: {FindUsers, UserList},
    }
</script>
<style lang="scss" scoped>
    .admin-panel {
        &__wrapper {
            padding: 24px;
            background-color: #fff;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
        }
    }
</style>
