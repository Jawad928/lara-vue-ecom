<script setup>
const props = defineProps({
  formValidationErrors: {
    type: Object,
    required: false,
    default: null,
  },
});
</script>
<template>
  <div class="row m-3">
    <ul
      class="list-group-my-2"
      v-for="(validationError, index) in formValidationErrors"
      :key="index"
    >
      <li
        class="list-group-item bg-danger text-white mb-1 rounded-0"
        v-for="(error, index) in validationError"
        :key="index"
      >
        {{ error }}
      </li>
    </ul>
  </div>
</template>
<style scoped></style>
