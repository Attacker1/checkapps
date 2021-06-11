<template>
    <div class="find-users">
        <form class="find-users__form">
            <div class="find-users__wrapper">
                <input v-model="text" type="text" class="form_input find-users__input">
                <select v-model="selectedValue" class="find-users__select" @change="onChange">
                    <option value="email">Email</option>
                    <option value="fio">ФИО</option>
                </select>
            </div>
            <button type="submit" @click.prevent="search" class="button_colored find-users__search">Поиск</button>
        </form>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';
    import IconLense from "@/assets/icons/IconLense";
    import UserCard from '@/components/admin/UserCard';

    export default {
        name: 'FindUsers',
        components: {IconLense, UserCard},
        props: {
            sortByActive: {
                type: String,
            },
            sortByStatus: {
                type: String,
            }
        },
        data: () => ({
            text: '',
            timer: '',
            timeoutObject: '',
            selectedValue: 'email'
        }),

        methods: {
            ...mapActions({
                fetchUsers: 'admin/fetchUsers',
            }),

            setTimer() {
                this.findData = 500;
            },

            onChange() {
                this.search();
            },

            search(force = false) {
                if ((this.text.trim() !== '' && this.text.length > 0) || force) {
                    // console.log('Ищу юзеров по запросу: ' + this.text.trim());
                    let params = {
                        paginate: 10,
                        page: 1,
                        s: this.text ? this.text.trim() : '',
                        searchBy: this.selectedValue === 'email' ? 'user_email' : 'user_fio',
                        filter: this.sortByActive === 'most_active' ? 'DESC' : 'ASC'
                    };
                    switch (this.sortByStatus) {
                        case 'all':
                            break;
                        case 'blocked':
                            params['isBanned'] = 'true';
                            break;
                        case 'unblocked':
                            params['isBanned'] = 'false';
                            break;
                    }
                    this.fetchUsers(params);
                }
            }
        },

        watch: {
            text: {
                handler: function () {
                    clearInterval(this.timeoutObject);
                    this.setTimer();
                    this.timeoutObject = setTimeout(() => {
                        this.search(true);
                    }, this.findData);
                }
            },

            sortByActive: {
                handler: function () {
                    this.search(true);
                }
            },

            sortByStatus: {
                handler: function () {
                    this.search(true);
                }
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
            justify-content: space-between;
            border: 1px solid #bdbdbd;
            border-radius: 5px;
            margin: 0;

            @media screen and (max-width: 767px) {
                flex-direction: column;
                border: none;
            }
        }

        &__wrapper {
            display: flex;
            justify-content: space-between;
            width: 100%;

            @media screen and (max-width: 767px) {
                border: 1px solid #bdbdbd;
                border-radius: 5px;
            }
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
            margin-bottom: 0;
            border-radius: 0;

            @media screen and (max-width: 767px) {
                margin-top: 20px;
            }
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
