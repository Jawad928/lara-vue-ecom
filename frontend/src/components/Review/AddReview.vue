<script setup>
import { reactive } from "vue";
import { useProductDetailStore } from "../../stores/useProductDetailStore";

import Spinner from "../layouts/Spinner.vue";
import StarRating from "vue-star-rating";
//define store
const ProductDetailStore = useProductDetailStore();

//define the data object

const data = reactive({
  review: {
    title: "",
    body: "",
    rating: 0,
  },
});

//add function to submit the review
const addReview = () => {
  ProductDetailStore.storeReview(data.review);

  data.review = { title: "", body: "", rating: 0 };
};
</script>

<template>
  <div class="card mb-2">
    <Spinner :store="ProductDetailStore"></Spinner>

    <div class="card-header bg-white">
      <h5 class="text-center mt-2">Add Your Review</h5>
    </div>

    <div class="card-body">
      <form @submit.prevent="addReview" class="mt-5 col-md-10 mx-auto">
        <div class="mb-3">
          <label for="" class="form-label">Title*</label>
          <input
            type="text"
            class="form-control"
            name="title"
            id="title"
            :required="true"
            v-model="data.review.title"
            aria-describedby="helpId"
            placeholder="title"
          />
        </div>

        <div class="mb-3">
          <label for="body" class="form-label">Review*</label>
          <textarea
            class="form-control"
            name="body"
            v-model="data.review.body"
            id="body"
            rows="3"
          ></textarea>
        </div>

        <div class="mb-3">
          <StarRating
            v-model:rating="data.review.rating"
            :show-rating="false"
          />
        </div>

        <button
          type="submit"
          class="btn btn-dark"
          :disabled="data.review.rating == 0"
        >
          Submit
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped></style>
