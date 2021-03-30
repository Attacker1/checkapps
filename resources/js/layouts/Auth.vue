<template>
  <div class="auth">
    <div class="container">
      <div class="auth-wrap">
        <router-view/>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'AuthLayout',
  mounted() {
  }
}
</script>

<style lang="scss" scoped>
.auth {
  display: flex;
  align-content: center;
  justify-content: center;
  flex-direction: column;
  position: relative;
  min-height: 100vh;

  &-wrap {
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
</style>
