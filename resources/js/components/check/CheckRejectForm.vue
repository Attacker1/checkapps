<template>
    <form class="reject-form card_bg-light card_r-12 card_shadow px-sm-20 px-30 py-25 py-sm-20"
          @submit.prevent="rejectCheck">
        <h3 class="title text_center mb-30 mb-sm-20">Причина отклонения</h3>
        <div>
            <FormRadio @change="$v.toggle.$touch" v-model="toggle" name="reject"
                       value="На фотографии отсутствует дата покупки"/>
            <FormRadio @change="$v.toggle.$touch" v-model="toggle" name="reject"
                       value="Кэшбэк за перевод с карты на карту/другому человеку не учитывается"/>
            <FormRadio @change="$v.toggle.$touch" v-model="toggle" name="reject"
                       value="Кэшбэк за товарный чек/приходник не учитывается"/>
            <FormRadio @change="$v.toggle.$touch" v-model="toggle" name="reject" value="Низкое качество фотографии"/>
            <FormRadio @change="$v.toggle.$touch" v-model="toggle" name="reject"
                       value="Дата покупки отличается от указанной"/>
            <FormRadio @change="$v.toggle.$touch" v-model="toggle" name="reject"
                       value="Сумма покупки отличается от указанной"/>
            <FormRadio @change="$v.toggle.$touch" v-model="toggle" name="reject" value="Другое"/>
            <textarea @input="$v.comment.$touch" v-if="textarea" class="textarea mb-5" placeholder="Причина отклонения"
                      v-model="comment"/>
            <div class="errors" v-if="$v.toggle.$dirty">
                <div class="error" v-if="!$v.toggle.required">Выберите один их пунктов</div>
                <div v-if="textarea && $v.comment.$dirty">
                    <div class="error" v-if="!$v.comment.minLength">Минимальное количество символов
                        {{$v.comment.$params.minLength.min}}
                    </div>
                    <div class="error" v-if="!$v.comment.required">Поле обязательно для заполнения</div>
                </div>
            </div>
        </div>
        <button class="button button_primary button_sm button_block text_lg mt-20">Отклонить чек</button>
    </form>
</template>

<script>
    import FormRadio from "@/components/form/FormRadio";
    import {required, minLength} from 'vuelidate/lib/validators';
    import {mapActions} from "vuex";

    export default {
        name: "CheckRejectForm",
        components: {FormRadio},
        data: () => ({
            toggle: '',
            comment: '',
            textarea: false,
            message: '',
        }),
        computed: {
            rules() {
                if (this.toggle === 'Другое') {
                    return {comment: {minLength: minLength(10), required}}
                }
            }
        },
        validations() {
            return {
                ...this.rules,
                toggle: {
                    required
                }
            }
        },
        methods: {
            ...mapActions({
                reject: 'checkActions/sendReject'
            }),
            rejectCheck() {
                this.$v.$touch();
                if (this.$v.$pending || this.$v.$error) return;

                if (this.textarea) {
                    this.message = this.comment;
                } else {
                    this.message = this.toggle;
                }
                this.reject(this.message);
                this.$emit('closeRejectForm')
            },
        },
        watch: {
            toggle: function (toggleValue) {
                this.textarea = toggleValue === 'Другое';
            }
        }
    }
</script>

<style lang="scss" scoped>
    .error {
        font-size: 12px;
        color: $error;
        line-height: 10px;
    }
</style>
