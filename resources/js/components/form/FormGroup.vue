<template>
  <div
      class="form-group"
      :class="{ hasError: hasAnyErrors, hasSuccess: isFullyValid }">
    <div class="control">
      <slot/>
    </div>
    <div class="control-helper text_sm pl-5 message_error" v-if="hasAnyErrors">
      <div v-for="error in activeErrorMessages" :key="error">{{ error }}</div>
      <div v-for="error in serverErrors" :key="error">{{ error }}</div>
    </div>
  </div>
</template>
<script>
import {singleErrorExtractorMixin} from "vuelidate-error-extractor";

export default {
  mixins: [singleErrorExtractorMixin],
  props: {
    serverErrors: {
      type: Array,
      default: () => []
    }
  },
  computed: {
    hasAnyErrors() {
      return this.hasErrors || this.serverErrors.length;
    },
    isFullyValid() {
      return this.isValid && !this.serverErrors.length;
    }
  }
};
</script>

<style lang="scss" scoped>
.message_error {
  color: $error;
}
</style>
