<script setup>
import { useProductStore } from "../../stores/useProductStore";
import Brands from "../partials/Brands.vue";
import Categories from "../partials/Categories.vue";
import Colors from "../partials/Colors.vue";
import Sizes from "../partials/Sizes.vue";
import SearchForm from "../partials/SearchForm.vue";
const productStore = useProductStore();
</script>
<template>
  <div class="col-md-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h5>Filters</h5>

      <button
        class="btn btn-link text-dark"
        @click="productStore.clearFilters()"
      >
        Clear all
      </button>
    </div>
    <SearchForm />
    <Categories />
    <Brands />
    <Sizes />
    <Colors />
  </div>
</template>
<style scoped></style>
