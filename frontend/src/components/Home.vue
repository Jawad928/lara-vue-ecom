<script setup>
import { useProductStore } from "../stores/useProductStore";
import { onMounted } from "vue";

const productsStore = useProductStore();

onMounted(() => {
  productsStore.fetchAllProducts();
});
</script>

<template>
  <div>Home Page</div>
</template>

<style scoped></style>
