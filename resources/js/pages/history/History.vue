<template>
    <div class="history">
        <div class="history__wrapper">
            <h2 class="history__title">Баланс</h2>
            <div class="title_md history__balance-count">{{ (user.balance ? user.balance : 0) | curr }} CFR</div>
        </div>
        <div class="history__wrapper">
            <h2 class="history__title">История действий</h2>
            <div v-if="checks.length" class="history__review">
                <CheckCard v-for="check in checks" :key="check.check_id" :check-data="check"/>
            </div>
            <Pagination @change-page="changePage" v-if="checks.length" :links="links"/>
        </div>
    </div>
</template>
<script>
import HistoryReview from '@/components/history/HistoryReview';
import {mapGetters} from "vuex";
import axios from 'axios';
import CheckCard from '../../components/history/CheckCard';
import Pagination from '../../components/pagination/Pagination';

export default {
    name: 'History',
    components: {Pagination, CheckCard, HistoryReview},
    computed: {
        ...mapGetters('auth', ['user']),
    },
    data: () => ({
        checks: [],
        links: [],
        currentPage: 1,
        lastPage: {
            Type: Number,
        }
    }),

    methods: {
        async getHistory() {
            try {
                const response = await axios.get('check-histories', {
                    params: {
                        paginate: 2,
                        page: this.currentPage,
                    }
                })
                this.checks = response.data.data;
                this.links = response.data.links;
                this.lastPage = response.data.last_page;
                this.currentPage = response.data.current_page;
            } catch (response) {
                console.log(response)
            }
        },

        changePage(val) {
            if (val.link.url) {
                const url = new URL(val.link.url);
                url.searchParams.has('page') ? this.currentPage = url.searchParams.get('page') : ''
                this.getHistory();
            }
        }
    },

    async beforeMount() {
        await this.getHistory()
    }
}
</script>
<style lang="scss" scoped>
.history {
    &__balance {
        &-count {
            font-weight: 600;
        }
    }

    &__title {
        font-weight: 500;
        margin-bottom: 16px;
    }

    &__wrapper {
        padding: 24px;
        background-color: #fff;
        border-radius: 12px;
        margin-bottom: 24px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
    }

    &__review {
        margin-top: 24px;
    }
}
</style>
