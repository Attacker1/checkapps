<template>
  <AuthDefault>
    <template slot="title">Авторизация</template>
    <form @submit.prevent="submitForm">
      <div class="mb-8">
        <FormGroup :server-errors="serverErrors.login" :validator="$v.form.login" label="Логин">
          <input
              v-model="form.login"
              placeholder="Логин"
              class="input">
        </FormGroup>
      </div>
      <div class="mb-25">
        <FormGroup :server-errors="serverErrors.password" :validator="$v.form.password" label="Пароль">
          <input
              type="password"
              v-model="form.password"
              placeholder="Пароль"
              class="input">
        </FormGroup>
      </div>
      <button type="submit" class="button button_primary button_block mb-2 text_bold text_lg">Войти</button>
    </form>
  </AuthDefault>
</template>

<script>
import AuthDefault from "@/components/auth/AuthDefault";
import {required} from 'vuelidate/lib/validators';
import FormGroup from "@/components/form/FormGroup";
import {mapActions} from "vuex";


export default {
  name: "Login",
  components: {FormGroup, AuthDefault},
  data: () => ({
    form: {
      login: null,
      password: null,
    },
    serverErrors: {}
  }),
  validations: {
    form: {
      login: {required_m: required},
      password: {required_m: required}
    },
  },
  methods: {
    ...mapActions({
      login: 'auth/LogIn',
    }),
    submitForm() {
      this.$v.$touch();
      if (!this.$v.$pending && !this.$v.$error) {
        this.login(this.form)
      }
    },
  },
  watch: {
    form: {
      handler() {
        if (Object.keys(this.serverErrors).length) {
          this.serverErrors = {};
        }
      },
      deep: true
    }
  },

}
</script>