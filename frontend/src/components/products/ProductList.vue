<script setup>
import ProductListItem from "./ProductListItem.vue";
import { useProductStore } from "../../stores/useProductStore";
import { reactive } from "vue";
const productsStore = useProductStore();

//define how many product show on home.vue

const data = reactive({
  productToShow: 6,
});

//define the function to load more products
const loadMoreProducts = () => {
  if (data.productToShow < productsStore.products.length) {
    data.productToShow = data.productToShow + 6;
  } else {
    return;
  }
};
</script>

<template>
  <div class="row">
    <div class="d-flex">
      <div class="mb-3">
        Found
        <span class="fw-bold">
          {{ productsStore.products.length }}
          {{ productsStore.products.length > 1 ? "products" : "product" }}</span
        >
      </div>
      <div class="ms-1" v-if="productsStore.filter">
        for
        <span class="fw-bold">
          {{ productsStore.filter.param }} {{ productsStore.filter.value }}
        </span>
      </div>
    </div>

    <ProductListItem
      v-for="product in productsStore.products.slice(0, data.productToShow)"
      :key="product.id"
      :product="product"
    />
  </div>
  <div class="d-flex justify-content-center">
    <button
      type="submit"
      class="btn btn-sm btn-dark mt-3"
      v-if="data.productToShow < productsStore.products.length"
      @click="loadMoreProducts"
    >
      <i class="bi bi-arrow-clockwise"></i> Load more
    </button>
  </div>
</template>

<style scoped></style>
