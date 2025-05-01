<script setup>
import { useProductStore } from "../stores/useProductStore";
import { onMounted, watchEffect } from "vue";
import ProductList from "./products/ProductList.vue";
import Spinner from "./layouts/Spinner.vue";
import Sidebar from "./layouts/Sidebar.vue";
const productsStore = useProductStore();

onMounted(() => {
  productsStore.fetchAllProducts();
});
</script>

<template>
  <div class="row my-5">
    <Spinner :store="productsStore" />
    <Sidebar />
    <div class="col-md-8">
      <ProductList />
    </div>
  </div>
</template>

<style scoped></style>
