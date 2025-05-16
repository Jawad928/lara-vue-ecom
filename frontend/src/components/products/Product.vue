<script setup>
import { computed, onMounted, reactive } from "vue";
import { useProductDetailStore } from "../../stores/useProductDetailStore";
import { useRoute } from "vue-router";
import Spinner from "../layouts/Spinner.vue";
import { useCartStore } from "../../stores/useCartStore";
import { makeUniqueId } from "../../helpers/config";
import { useAuthStore } from "../../stores/useAuthStore";
import AddReview from "../Review/AddReview.vue";
import ReviewList from "../Review/ReviewList.vue";
import UpdateReview from "../Review/UpdateReview.vue";
import StarRating from "vue-star-rating";

const ProductDetailStore = useProductDetailStore();

//define store
const authStore = useAuthStore();

// define the route
const route = useRoute();

//data object for qty
const data = reactive({
  qty: 1,
  chosenColor: null,
  chosenSize: null,
});

//set chosen color
const setChosenColor = (color) => {
  data.chosenColor = color;
};
//set chosen size
const setChosenSize = (size) => {
  data.chosenSize = size;
};

const cartStore = useCartStore();

//check if user has bought the product
const checkIfUserBoughtTheProduct = () => {
  return authStore.user?.orders?.some((order) =>
    order?.products?.some(
      (product) => product.id === ProductDetailStore.product?.id
    )
  );
};

//calculate the avg rating of review

const avgReview = computed(() =>
  ProductDetailStore.product?.reviews?.reduce(
    (acc, review) =>
      acc + review.rating / ProductDetailStore.product.reviews.length,
    0
  )
);

//once the component is mounted we fetch the product
onMounted(() => ProductDetailStore.fetchAllProducts(route.params.slug));
</script>
<template>
  <Spinner :store="ProductDetailStore"></Spinner>

  <div v-if="ProductDetailStore.product">
    <div class="row my-5">
      <div class="col-md-6">
        <div>
          <!-- product images -->
          <vue-image-zoomer
            img-class="img-fluid rounded"
            :regular="ProductDetailStore.product?.thumbnail"
            :zoom="ProductDetailStore.product?.thumbnail"
            :zoom-amount="2"
          />
        </div>

        <div class="d-flex flex-wrap gap-2 my-3">
          <div
            v-for="productImage in ProductDetailStore.productImages"
            :key="productImage.id"
          >
            <vue-image-zoomer
              img-class="img-fluid rounded"
              :regular="productImage.src"
              :zoom="productImage.src"
              :zoom-amount="2"
              :img-width="300"
              :img-height="300"
            />
          </div>
        </div>
      </div>

      <div class="col-md-5 mx-auto">
        <div v-if="ProductDetailStore.product?.reviews.length > 0">
          <StarRating
            v-model:rating="avgReview"
            :show-rating="false"
            read-only
            :star-size="24"
          />
          <small class="text-muted">
            {{ ProductDetailStore.product?.reviews.length }}
            {{
              ProductDetailStore.product?.reviews.length > 1
                ? "reviews"
                : "review"
            }}
          </small>
        </div>

        <h5 class="my-3">
          {{ ProductDetailStore.product?.name }}
        </h5>

        <div class="d-inline-flex">
          <span class="badge text-bg-light">
            <i class="bi bi-tag">
              {{ ProductDetailStore.product?.category.name }}
            </i>
          </span>

          <span class="badge text-bg-light ms-3">
            <i class="bi bi-c-circle">
              {{ ProductDetailStore.product?.brand.name }}
            </i>
          </span>
        </div>

        <p class="my-3" v-dompurify-html="ProductDetailStore.product?.desc"></p>

        <div class="mb-2">
          <span class="h5"> ${{ ProductDetailStore.product?.price }} </span>
        </div>

        <div class="d-flex flex-wrap justify-content-start">
          <div
            :class="[
              data.chosenColor?.id === color.id
                ? 'border border-light-subtle shadow-sm border-2 rounded'
                : '',
              'mb-1 me-1',
            ]"
            v-for="color in ProductDetailStore.product?.colors"
            :key="color.id"
            @click="setChosenColor(color)"
            :style="{
              backgroundColor: color.name,
              width: '30px',
              height: '30px',
              cursor: 'pointer',
            }"
          ></div>
        </div>

        <div
          class="d-flex flex-wrap justify-content-start align-items-center mt-3 mb-2"
        >
          <button
            :class="[
              data.chosenSize?.id === size.id
                ? 'btn btn-danger mb-3 mx-1 rounded-0'
                : 'btn btn-outline-secondary btn-sm text-dark mb-3 mx-1',
            ]"
            v-for="size in ProductDetailStore.product?.sizes"
            :key="size.id"
            @click="setChosenSize(size)"
          >
            {{ size.name }}
          </button>
        </div>

        <div>
          <span
            class="badge bg-success"
            v-if="ProductDetailStore.product?.status"
          >
            In Stock</span
          >
          <span class="badge bg-warning" v-else> Out of Stock</span>
        </div>

        <div class="my-3 d-inline-flex">
          <div>
            <input
              type="number"
              v-model="data.qty"
              min="1"
              :max="ProductDetailStore.product?.qty"
              class="form-control"
            />
          </div>

          <div class="ms-2">
            <button
              :disabled="
                !data.chosenColor ||
                !data.chosenSize ||
                !ProductDetailStore.product?.status
              "
              class="btn btn-danger btn-block"
              @click="
                cartStore.addToCart({
                  ref: makeUniqueId(10),
                  product_id: ProductDetailStore.product?.id,
                  name: ProductDetailStore.product?.name,
                  slug: ProductDetailStore.product?.name,
                  qty: data.qty,
                  price: ProductDetailStore.product?.price,
                  color: data.chosenColor?.name,
                  size: data.chosenSize?.name,
                  maxQty: ProductDetailStore.product?.qty,
                  image: ProductDetailStore.product?.thumbnail,
                  coupon_id: null,
                })
              "
            >
              <i class="bi bi-cart-plus"></i> Add to cart
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="row my-4">
      <div class="col-md-8 mx-auto">
        <ReviewList />

        <div v-if="authStore.isLoggedIn">
          <div v-if="checkIfUserBoughtTheProduct()">
            <UpdateReview v-if="ProductDetailStore.reviewToUpdata.updating" />
            <AddReview v-else />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
