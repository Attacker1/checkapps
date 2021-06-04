<template>
    <div class="find-users">
        <form class="find-users__form">
            <input v-model="text" type="text" class="form_input find-users__input">
            <IconLense class="find-users__icon"/>
        </form>
        <ul class="find-users__suggestions" v-if="users.length !== 0">
            <li class="find-users__suggestion" v-for="(user, index) in users">
                <UserCard :user="user" :key="index"/>
            </li>
        </ul>
    </div>
</template>
<script>
    import IconLense from "@/assets/icons/IconLense";
    import UserCard from '@/components/admin/UserCard';

    export default {
        name: 'FindUsers',
        components: {IconLense, UserCard},
        data: () => ({
            text: '',
            timer: '',
            timeoutObject: '',
            users: [
                /*{
                    balance: null,
                    check_history_count: 0,
                    id: 1,
                    user_email: "chekapps.com@gmail.com",
                    user_fio: "chekapps.com@gmail.com",
                    user_id: 513753,
                    user_phone: "+79276724306"
                },
                {
                    balance: 23,
                    check_history_count: 4,
                    id: 2,
                    user_email: "chekapps.com@gmail.com",
                    user_fio: "chekapps.com@gmail.com",
                    user_id: 513753,
                    user_phone: "+79276724306"
                }*/
            ]
        }),

        methods: {
            setTimer() {
                this.findData = 1000;
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
        }

        &__input {
            padding-right: 45px;
        }

        &__icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            background-color: #fff;
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
