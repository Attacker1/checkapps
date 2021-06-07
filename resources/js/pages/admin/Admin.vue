<template>
    <div class="admin-panel">
        <div class="admin-panel__wrapper">
            <h2 class="admin-panel__title admin-panel__title-find">Поиск пользователей</h2>
            <FindUsers :sortby="sortby" />
        </div>
        <div class="admin-panel__wrapper">
            <div class="admin-panel__wrapper-top">
                <h2 class="admin-panel__title">Список пользователей</h2>
                <select v-model="sortby" class="admin-panel__sortby" :style="{backgroundImage: 'url(/images/svg/arrow.svg)'}">
                    <option value="1">Самые активные</option>
                    <option value="2">Самые неактивные</option>
                </select>
            </div>
            <UserList/>
        </div>
    </div>
</template>
<script>
    import FindUsers from '@/components/admin/FindUsers';
    import UserList from '@/components/admin/UserList';

    export default {
        name: 'Admin',
        components: {FindUsers, UserList},
        data: () => ({
            sortby: '1',
        })
    }
</script>
<style lang="scss" scoped>
    .admin-panel {
        &__title {
            font-weight: 500;

            &-find {
                margin-bottom: 16px;
            }
        }

        &__wrapper {
            padding: 24px;
            background-color: #fff;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);

            @media screen and (max-width: 480px) {
                padding: 16px;
            }

            &-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;

                @media screen and (max-width: 480px) {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        }

        &__sortby {
            padding: 10px 30px 10px 15px;
            border: 1px solid #bdbdbd;
            outline: none;
            border-radius: 5px;
            font-size: 17px;
            text-align: center;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            position: relative;
            background-color: transparent;
            background-repeat: no-repeat;
            background-size: 13px 10px;
            background-position: right 8px center;
            background-clip: border-box;
            -webkit-background-clip: border-box;

            @media screen and (max-width: 480px) {
                margin-top: 16px;
            }
        }
    }
</style>
