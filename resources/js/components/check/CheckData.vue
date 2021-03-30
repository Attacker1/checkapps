<template>
  <div class="check-data">
    <div class="table">
      <div class="table__item">
        <p class="text_grey">Дата добавления покупки</p>
        <p class="text_semibold">{{ check.dt }}</p>
      </div>
      <div class="table__item">
        <p class="text_grey">Дата совершения покупки</p>
        <p class="text_semibold">{{ check.dt_purchase }}</p>
      </div>
      <div class="table__item">
        <p class="text_grey">Сумма покупки в CFR</p>
        <p class="text_semibold">{{ check.amount }} CFR</p>
      </div>
      <div class="table__item">
        <p class="text_grey">Валюта</p>
        <p class="text_semibold">{{ check.currency }}</p>
      </div>
      <div class="table__item">
        <p class="text_grey">Сумма покупки в указанной валюте</p>
        <p class="text_semibold">{{ check.amount_in_currency }}</p>
      </div>
    </div>
    <CheckActions/>
  </div>
</template>

<script>
import CheckActions from '@/components/check/CheckActions';

export default {
  name: "CheckData",
  components: {CheckActions},
  props: {
    check: {
      id: null,
      dt: null,
      dt_purchase: null,
      amount: null,
      amount_in_currency: null,
      currency: null,
    }
  }
}
</script>

<style lang="scss" scoped>
.check-data {
  border: 0.5px solid rgba(0, 0, 0, 0.08);
  box-sizing: border-box;
  border-radius: 6px;
  background-color: white;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.table {
  &__item {
    padding: 16px 13px;
    grid-gap: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;

    &:nth-child(2n + 1) {
      background-color: #FAFAFA;
    }
  }
}
</style>