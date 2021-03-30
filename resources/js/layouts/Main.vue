<template>
  <div class="wrap">
    <Header/>
    <div class="content">
      <div class="container">
        <router-view/>
      </div>
    </div>
  </div>
</template>

<script>
import Header from '@/components/header/Header';

export default {
  name: 'MainLayout',
  components: {Header}
}
</script>

<style lang="scss" scoped>
.wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}

.content {
  width: 100%;
}
</style>
