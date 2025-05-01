<script setup>
import { useProductStore } from "../../stores/useProductStore";
const productStore = useProductStore();
</script>
<template>
  <div class="mb-3">
    <h6>Categories</h6>
    <ul class="nav d-flex flex-column">
      <li
        class="nav-item mb-2"
        v-for="category in productStore.categories"
        :key="category.id"
      >
        <button
          class="btn btn-link btn-sm text-dark"
          @click="productStore.filterProducts('category', category.slug)"
        >
          {{ category.name }}
        </button>
      </li>
    </ul>
  </div>
</template>
<style scoped></style>
