<template>
  <div class="check-view">
    <CheckImage/>
    <CheckData :check="check"/>
  </div>
</template>

<script>
import CheckImage from '@/components/check/CheckImage';
import CheckData from '@/components/check/CheckData';

export default {
  name: "CheckView",
  components: {CheckData, CheckImage},
  data: () => ({
    check: {
      id: 2,
      dt: '29.08.2020, 12:20',
      dt_purchase: '27.08.2020, 13:22',
      amount: 129,
      amount_in_currency: 672,
      currency: 'RUB',
    }
  })
}
</script>

<style lang="scss" scoped>
.check-view {
  display: grid;
  grid-template-columns: 1fr 1.1fr;
  grid-gap: 24px;
  grid-template-rows: 600px;
}
</style>