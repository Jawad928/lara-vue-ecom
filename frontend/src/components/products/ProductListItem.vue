<script setup>
const prop = defineProps({
  product: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="col-md-6">
    <div class="card mb-3" style="max-width: 320px">
      <img
        :src="product.thumbnail"
        class="card-img-top"
        :alt="product.name"
        height="279"
      />
      <div class="card-body">
        <router-link
          class="text-decoration-none text-dark"
          :to="`/product/${product.slug}`"
        >
          <h5 class="card-title">{{ product.name }}</h5>
        </router-link>

        <p class="card-text" v-dompurify-html="product.desc.substr(0, 45)"></p>
        <div class="d-flex justify-content-between align-items-center">
          <span class="h5 mb-0">${{ product.price }}</span>
          <div>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-half text-warning"></i>
            <small class="text-muted">(4.5)</small>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-between bg-light">
        <button class="btn btn-danger btn-sm">
          <i class="bi bi-cart-plus"></i> Add to Cart
        </button>
        <button class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-heart"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
