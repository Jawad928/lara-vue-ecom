<script setup>
import { useProductStore } from "../../stores/useProductStore";
const productStore = useProductStore();
</script>
<template>
  <div class="mb-3">
    <h6>Sizes</h6>
    <div class="d-flex flex-wrap justify-content-start align-items-center mb-4">
      <button
        class="btn btn-outline-secondary btn-sm text-dark mb-3 mx-1"
        v-for="size in productStore.sizes"
        :key="size.id"
        @click="productStore.filterProducts('size', size.id)"
      >
        {{ size.name }}
      </button>
    </div>
  </div>
</template>
<style scoped></style>
