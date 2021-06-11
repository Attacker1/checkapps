<template>
    <div class="settings">
        <div class="section-wrapper">
            <h2 class="settings__title">Настройки</h2>
            <div class="settings__wrapper">
                <form v-for="setting in settings" :key="setting.slug" @submit.prevent="submitForm(setting)" class="settings__form">
                    <span class="form_placeholder">{{setting.name}}</span>
                    <input type="number" step="any" min="0" placeholder="0,00" class="form_input settings__input" v-model="setting.value">
                    <button type="submit" class="button_colored">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import axios from 'axios';

    export default {
        name: 'Settings',
        data: () => ({
            settings: [],
        }),

        methods: {
            async getSettings() {
                this.$store.commit('common/setLoader', null, {root: true})
                try {
                    const response = await axios.get('settings');
                    this.settings = response.data;
                } catch (response) {
                    Vue.noty.error(response.response.data.error);
                }
                this.$store.commit('common/removeLoader', null, {root: true})
            },

            async setSettings(data) {
                try {
                    const response = await axios.post('settings/edit', data);
                    Vue.noty.success(response.data.message);
                } catch (e) {
                    Vue.noty.error(e.response.data.error);
                }
            },

            submitForm(newSettings) {
                let data = {
                    slug: newSettings.slug,
                    value: newSettings.value
                }
                this.setSettings(data);
            }
        },

        beforeMount() {
            this.getSettings();
        }
    }
</script>
<style lang="scss" scoped>
    .settings {
        &__title {
            font-weight: 500;
            margin-bottom: 30px;
        }

        &__wrapper {
            display: flex;
            flex-direction: column;
            margin-bottom: 0;

            .form_label {
                margin-bottom: 20px;
            }
        }

        &__form {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            align-items: center;

            @media screen and (max-width: 767px) {
                display: flex;
                flex-direction: column;
                gap: 0;
                margin-bottom: 30px;
            }
        }

        &__input {
            @media screen and (max-width: 767px) {
                margin-bottom: 10px;
            }
        }
    }
</style>
