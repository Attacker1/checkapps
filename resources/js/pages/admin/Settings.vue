<template>
    <div class="settings">
        <div class="section-wrapper">
            <h2 class="settings__title">Настройки</h2>
            <form class="settings__form" @submit.prevent="postSettings">
                <label class="form_label">
                    <span class="form_placeholder">Размер вознаграждения в CFR</span>
                    <input type="number" step="0.01" min="0" placeholder="0,00" class="form_input" v-model="reward">
                </label>
                <label class="form_label">
                    <span class="form_placeholder">Количество проверок 1 чека</span>
                    <input type="number" min="1" class="form_input" v-model="checkVerificationCount">
                </label>
                <label class="form_label">
                    <span class="form_placeholder">Минимальное кол-во чеков для отправки запроса</span>
                    <input type="number" min="1" class="form_input" v-model="checkCountMin">
                </label>
                <label class="form_label">
                    <span class="form_placeholder">Время жизни чеков</span>
                    <input type="number" min="1" class="form_input" v-model="checkLifeCount">
                </label>
                <label class="form_label">
                    <span class="form_placeholder">Кол-во подгружаемых чеков</span>
                    <input type="number" min="1" class="form_input" v-model="checkUploadCount">
                </label>
                <button type="submit" class="button_colored">Сохранить</button>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'Settings',
        data: () => ({
            reward: 0,
            checkVerificationCount: 0,
            checkCountMin: 0,
            checkLifeCount: 0,
            checkUploadCount: 0,
        }),

        methods: {
            postSettings() {

            }
        },
    }
</script>
<style lang="scss" scoped>
    .settings {
        &__title {
            font-weight: 500;
            margin-bottom: 30px;
        }

        &__form {
            display: flex;
            flex-direction: column;
            margin-bottom: 0;

            .form_label {
                margin-bottom: 20px;
            }
        }
    }
</style>
