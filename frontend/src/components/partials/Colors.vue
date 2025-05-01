<script setup>
import { useProductStore } from "../../stores/useProductStore";
const productStore = useProductStore();
</script>
<template>
  <div class="mb-3">
    <h6>Colors</h6>

    <div class="d-flex flex-wrap justify-content-start">
      <div
        class="border border-light-subtle shadow-sm border-2 rounded mb-1 me-1"
        v-for="color in productStore.colors"
        :key="color.id"
        @click="productStore.filterProducts('color', color.id)"
        :style="{
          backgroundColor: color.name,
          width: '30px',
          height: '30px',
          cursor: 'pointer',
        }"
      ></div>
    </div>
  </div>
</template>
<style scoped></style>
