<template>
  <header class="header">
    <div class="container d-flex align-center justify-between">
      <div class="d-flex align-center">
        <IconProfile class="mr-20"/>
        <div>
          <p class="text text_bold">{{ user_fio }}</p>
          <p class="text_sm text_grey">{{ user_email }}</p>
        </div>
      </div>
      <div>
        <router-link class="text_decornone logout-link text_grey text_md" :to="{name: 'Logout'}" tag="a">Выйти
        </router-link>
      </div>
    </div>
  </header>
</template>

<script>
import IconProfile from '@/assets/icons/IconProfile';

export default {
  name: 'Header',
  components: {IconProfile},
  data: () => ({
    user_fio: 'Иван Иванов',
    user_email: 'mail@mail.ru'
  }),
  methods: {
    async logout() {
      await this.$store.dispatch('auth/LogOut');
      this.$router.push({name: 'Logout'});
    },
  }
}
</script>

<style lang="scss" scoped>
.header {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  padding-top: 30px;
}

.logout-link {
  transition: color ease 200ms;

    &:hover {
        color: $primary;
    }
}
</style>
