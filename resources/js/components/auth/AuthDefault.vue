<template>
  <div class="auth-form form card_r-12 card_bg-light card_shadow pa-sm-15 pa-35">
    <div class="auth-form__wrapper">
      <h3 class="auth-form__title text_center my-0 title mb-25">
        <slot name="title"/>
      </h3>
      <slot name="default"/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AuthDefault',
}
</script>

<style lang="scss" scoped>
.auth-form {
  max-width: 410px;
  width: 100%;
  margin: auto;
}
</style>
