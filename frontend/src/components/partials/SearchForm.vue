<script setup>
import { reactive } from "vue";
import { useProductStore } from "../../stores/useProductStore";

const productsStore = useProductStore();

const data = reactive({
  term: "",
});

const searchForProducts = () => {
  productsStore.filterProducts("find", data.term, true);
  data.term = "";
};
</script>
<template>
  <div class="mb-3 d-flex">
    <input
      type="text"
      v-model="data.term"
      class="form-control rounded-0"
      placeholder="search..."
    />
    <button
      class="btn btn-sm btn-dark search__button"
      @click="searchForProducts"
      :disabled="!data.term"
    >
      <i class="bi bi-search"></i>
    </button>
  </div>
</template>
<style scoped>
.search__button {
  border-top-right-radius: 15px;
  border-bottom-right-radius: 15px;
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}
</style>
