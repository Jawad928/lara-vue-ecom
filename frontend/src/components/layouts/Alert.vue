<script setup>
const props = defineProps({
  content: {
    type: String,
    required: true,
  },
  bgColor: {
    type: String,
    required: true,
  },
});
</script>
<template>
  <div class="row mt-4">
    <div class="col-md-8 mx-auto">
      <div :class="`alert alert-${bgColor} mt-2`">
        <i class="bi bi-exclamation-triangle me-2">{{ content }}</i>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
