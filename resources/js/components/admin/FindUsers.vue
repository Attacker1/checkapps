<template>
    <div class="find-users">
        <form class="find-users__form">
            <input v-model="text" type="text" class="form_input find-users__input">
            <select name="select2" class="find-users__select">
<!--                <option selected="selected">Искать по</option>-->
                <option>Email</option>
                <option>ФИО</option>
            </select>
            <button type="submit" @click.prevent="" class="find-users__search">Поиск</button>
        </form>
        <!--<ul class="find-users__suggestions" v-if="users.length !== 0">
            <li class="find-users__suggestion" v-for="(user, index) in users">
                <UserCard :user="user" :key="index"/>
            </li>
        </ul>-->
    </div>
</template>
<script>
    import {mapActions} from 'vuex';
    import IconLense from "@/assets/icons/IconLense";
    import UserCard from '@/components/admin/UserCard';

    export default {
        name: 'FindUsers',
        components: {IconLense, UserCard},
        data: () => ({
            text: '',
            timer: '',
            timeoutObject: '',
        }),

        methods: {
            ...mapActions({
                fetchUsers: 'admin/fetchUsers',
            }),

            setTimer() {
                this.findData = 500;
            },
        },

        watch: {
            text: {
                handler: function () {
                    clearInterval(this.timeoutObject);
                    this.setTimer();
                    this.timeoutObject = setTimeout(() => {
                        if (this.text.trim() !== '' && this.text.length > 1) {
                            console.log('Ищу юзеров по запросу: ' + this.text.trim());
                            let params = {
                                paginate: 10,
                                page: 1,
                                s: this.text.trim(),
                                searchBy: 'user_fio'
                            }
                            this.fetchUsers(params);
                        }
                        if (this.text.trim() === '') {
                            this.fetchUsers();
                        }
                    }, this.findData);
                },
                immediate: true
            }
        },
    }
</script>
<style lang="scss" scoped>
    .find-users {
        position: relative;

        &__form {
            position: relative;
            display: flex;
            border: 1px solid #bdbdbd;
            border-radius: 5px;
            margin: 0;
        }

        &__input {
            margin-right: 20px;
            border: none;
        }

        &__select {
            height: 52px;
            padding: 10px 15px;
            border: none;
            border-left: 1px solid #bdbdbd;
            margin-right: 15px;
            outline: none;
            font-size: 17px;
        }

        &__icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            background-color: #fff;
        }

        &__search {
            background: #3cb13c;
            color: #fff;
            display: inline-block;
            border: none;
            outline: none;
            font-weight: 400;
            font-size: 19px;
            padding: 14.5px 41px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 0;
        }

        &__suggestions {
            list-style-type: none;
            background-color: #fff;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            border-radius: 6px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.07);
        }

        &__suggestion {
            margin-bottom: 20px;

            &:last-child {
                margin-bottom: 0;
            }
        }
    }
</style>
