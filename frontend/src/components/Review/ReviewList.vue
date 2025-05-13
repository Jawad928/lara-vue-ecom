<script setup>
import { useProductDetailStore } from "../../stores/useProductDetailStore";
import { useAuthStore } from "../../stores/useAuthStore";
import StarRating from "vue-star-rating";
import Alert from "../layouts/Alert.vue";

const ProductDetailStore = useProductDetailStore();
const AuthStore = useAuthStore();
</script>

<template>
  <div class="card mb-2">
    <h5 class="text-center mt-2">
      Reviews ({{ ProductDetailStore.product.reviews.length }})
    </h5>
    <div class="card-body">
      <ul
        class="mt-4 list-group"
        v-if="ProductDetailStore.product.reviews.length"
      >
        <li
          class="list-group-item d-flex justify-content-between align-items-center"
          v-for="review in ProductDetailStore.product.reviews"
          :key="review.id"
        >
          <img
            :src="review.user.image_path"
            :alt="review.user.name"
            width="50"
            height="50"
            class="rounded-circle me-2"
          />

          <div class="ms-2 me-auto">
            <span class="fw-bold">
              {{ review.title }}
            </span>

            <p class="card-text">
              {{ review.body }}
            </p>
            <div>
              <small class="text-body-secondary"
                >Review by {{ review.user.name }}
                <span class="text-danger">
                  - {{ review.created_at }}</span
                ></small
              >
            </div>

            <div>
              <StarRating
                v-model:rating="review.rating"
                :show-rating="false"
                read-only
                :star-size="20"
              />
            </div>
          </div>

          <div
            class="d-flex flex-column align-items-center"
            v-if="AuthStore.isLoggedIn && AuthStore.user.id === review.user_id"
          >
            <button class="btn btn-sm btn-danger mb-2">
              <i class="bi bi-trash"></i>
            </button>
            <button
              class="btn btn-sm btn-warning mb-2"
              @click="ProductDetailStore.editReview(review)"
            >
              <i class="bi bi-pencil"></i>
            </button>
          </div>
        </li>
      </ul>
      <Alert v-else content="No Reviews Yet" bgColor="info"></Alert>
    </div>
  </div>
</template>

<style scoped></style>
