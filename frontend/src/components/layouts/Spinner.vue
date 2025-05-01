<script setup>
import { reactive, watchEffect } from "vue";
import Loading from "vue-loading-overlay";

//define props
const props = defineProps({
  store: {
    type: Object,
    required: true,
  },
});

// Debugging
// watchEffect(() => {
//   console.log("Spinner.vue: isLoading = ", props.store.isLoading);
// });
//define data object
const data = reactive({
  fullpage: true,
});
</script>
<template>
  <loading
    v-model:active="props.store.isLoading"
    :is-full-page="data.fullpage"
  />
</template>
<style scoped></style>
