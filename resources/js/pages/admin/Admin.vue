<template>
    <div class="admin-panel">
        <div class="section-wrapper">
            <h2 class="admin-panel__title admin-panel__title-find">Поиск пользователей</h2>
            <FindUsers :sortByActive="sortByActive" :sortByStatus="sortByStatus"/>
        </div>
        <div class="section-wrapper">
            <div class="admin-panel__wrapper-top">
                <h2 class="admin-panel__title">Список пользователей</h2>
                <div class="admin-panel__wrapper-right">
                    <select v-model="sortByStatus" class="admin-panel__sortby"
                            :style="{backgroundImage: 'url(/images/svg/arrow.svg)'}">
                        <option value="all">Все</option>
                        <option value="blocked">Заблокированные</option>
                        <option value="unblocked">Не заблокированные</option>
                    </select>
                    <select v-model="sortByActive" class="admin-panel__sortby"
                            :style="{backgroundImage: 'url(/images/svg/arrow.svg)'}">
                        <option value="most_active">Самые активные</option>
                        <option value="most_unactive">Самые неактивные</option>
                    </select>
                </div>
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
            sortByActive: 'most_active',
            sortByStatus: 'all',
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
            &-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;

                @media screen and (max-width: 767px) {
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

            @media screen and (max-width: 767px) {
                margin-top: 16px;
            }

            @media screen and (max-width: 500px) {
                width: 100%;
            }
        }
    }
</style>
