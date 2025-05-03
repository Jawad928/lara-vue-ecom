<script setup>
import { useAuthStore } from "../../stores/UseAuthStore";
import { useCartStore } from "../../stores/UseCartStore";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import { onMounted, computed } from "vue";
import Alert from "../layouts/Alert.vue";
import ProfileUserInfos from "../profile/ProfileUserInfos.vue";
import coupon from "../coupon/Coupon.vue";
import Stripe from "../payment/Stripe.vue";
// define  auth and cart store
const authStore = useAuthStore();
const cartStore = useCartStore();

// define toaster
const toast = useToast();

//define router
const router = useRouter();

//calculate the total price of the cart
const totalOfCartItems = cartStore.cartItems.reduce(
  (acc, item) => (acc += item.price * item.qty),
  0
);
// calculate the discount price
const calculatedDiscount = () =>
  totalOfCartItems * (cartStore.validCoupon.discount / 100);

//final total
const finalTotal = () => totalOfCartItems - calculatedDiscount();

const removeCoupon = () => {
  cartStore.setValidCoupon({
    name: "",
    discount: 0,
  });
  //set the coupon id to null for each item in the cart store
  cartStore.addCouponToCartItems(null);
  toast.success("Coupon removed successfully", {
    timeout: 2000,
  });
};

onMounted(() => {
  if (!cartStore.cartItems.length) {
    router.push("/");
  }
});
</script>
<template>
  <div class="row my">
    <ProfileUserInfos :updatingProfile="false"></ProfileUserInfos>
    <div class="col-md-4">
      <coupon />
      <ul class="list-group">
        <li
          class="list-group-item d-flex"
          v-for="product in cartStore.cartItems"
          :key="product.ref"
        >
          <img
            :src="product.image"
            :alt="product.name"
            width="60"
            height="60"
            class="img-fluid rounded me-2"
          />

          <div class="d-flex flex-column">
            <h6 class="my-1">
              <strong>{{ product.name }}</strong>
            </h6>
            <span class="text-muted">
              <strong>Color: {{ product.color }}</strong></span
            >
            <span class="text-muted">
              <strong>Color: {{ product.size }}</strong></span
            >
          </div>
          <div class="d-flex flex-column ms-auto">
            <span class="text-muted">
              ${{ product.price }} <i>x</i> {{ product.qty }}</span
            >
            <span class="text-muted fw-bold">
              ${{ product.price * product.qty }}</span
            >
          </div>
        </li>

        <li class="list-group-item d-flex justify-content-between">
          <span class="fw-bold"
            >Discount({{ cartStore.validCoupon.discount }})%</span
          >
          <span class="fw-normal text-danger" v-if="cartStore.validCoupon.name">
            {{ cartStore.validCoupon.name }}
            <i
              class="bi bi-trash"
              @click="removeCoupon"
              :style="{
                cursor: 'pointer',
              }"
            ></i>
          </span>
          <span class="fw-bold text-danger">
            -${{ calculatedDiscount() }}
          </span>
        </li>

        <li class="list-group-item d-flex justify-content-between">
          <span class="fw-bold"> Total</span>
          <span class="fw-bold text-danger"> ${{ finalTotal() }}</span>
        </li>
      </ul>
      <div class="my-3">
        <Stripe v-if="authStore.user?.profile_completed"> </Stripe>
        <Alert
          v-else
          content="Please add you billing Details"
          bgColor="warning"
        ></Alert>
      </div>
    </div>
  </div>
</template>
<style></style>
