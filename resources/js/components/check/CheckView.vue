<template>
    <div class="check-view">
        <CheckImage v-if="check" :receipt="check.image"/>
        <div class="check-data" v-if="check">
            <div class="table">
                <div class="table__item">
                    <p class="text_grey">Дата добавления покупки</p>
                    <p class="text_semibold">{{ check.dt | moment('DD.MM.YYYY, HH:mm') }}</p>
                </div>
                <div class="table__item">
                    <p class="text_grey">Дата совершения покупки</p>
                    <p class="text_semibold">{{ check.dt_purchase | moment('DD.MM.YYYY, HH:mm') }}</p>
                </div>
                <div class="table__item">
                    <p class="text_grey">Сумма покупки в CFR</p>
                    <p class="text_semibold">{{ check.amount.toFixed(2) | curr }} CFR</p>
                </div>
                <div class="table__item">
                    <p class="text_grey">Валюта</p>
                    <p class="text_semibold">{{ check.currency }}</p>
                </div>
                <div class="table__item">
                    <p class="text_grey">Сумма покупки в указанной валюте</p>
                    <p class="text_semibold">{{ check.amount_in_currency | curr }}</p>
                </div>
            </div>
            <CheckActions/>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import CheckActions from "@/components/check/CheckActions";
    import IconZoom from "@/assets/icons/IconZoom";
    import Modal from "@/components/modal/Modal";
    import CheckImage from "@/components/check/CheckImage";
    import Loader from "@/components/loader/Loader";

    export default {
        name: 'CheckView',
        components: {Loader, CheckImage, Modal, IconZoom, CheckActions},
        computed: {
            ...mapGetters({
                check: 'currentCheck/currentCheck',
                loader: 'common/loader'
            })
        },
    }
</script>

<style lang="scss" scoped>
    .check-view {
        width: 100%;
        position: relative;
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        grid-gap: 24px;
        grid-template-rows: 600px;

        @media screen and (max-width: 767px) {
            grid-template-columns: 1fr;
            grid-gap: 12px;
        }
    }

    .check-data {
        border: 0.5px solid rgba(0, 0, 0, 0.08);
        box-sizing: border-box;
        border-radius: 6px;
        background-color: white;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
        justify-content: space-between;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
    }

    .table {
        &__item {
            padding: 16px 13px;
            grid-gap: 20px;
            display: grid;
            align-items: center;
            grid-template-columns: 1fr 1fr;
            min-height: 53px;

            &:nth-child(2n + 2) {
                background-color: #FAFAFA;
            }

            @media screen and (max-width: 567px) {
                grid-template-columns: 1fr;
                grid-gap: 8px;
            }
        }
    }
</style>
