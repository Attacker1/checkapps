<template>
    <div class="notfound-banner">
        <h1 class="text_center notfound-banner__title">404</h1>
        <div class="text_center title_sm notfound-banner__subtitle">Страница не найдена</div>
        <button @click="goToMain" class="button button_primary button_sm text_lg">Перейти на главную</button>
    </div>
</template>
<script>
    export default {
        methods: {
            goToMain() {
                this.$router.push(
                    {
                        name: 'Main'
                    }
                )
            }
        }
    }
</script>
<style lang="scss">
    .notfound-banner {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        padding: 40px;
        background-color: #fff;
        border-radius: 12px;
        margin-bottom: 24px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);

        &__title {
            font-weight: 900;
            font-size: 144px;
            line-height: 174px;
        }

        &__subtitle {
            text-align: center;
            margin-bottom: 24px;
        }
    }
</style>
