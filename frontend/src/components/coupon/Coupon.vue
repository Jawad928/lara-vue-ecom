<script setup>
import { useAuthStore } from "../../stores/UseAuthStore";
import { useCartStore } from "../../stores/UseCartStore";
import { reactive } from "vue";
import { useToast } from "vue-toastification";
import { headerConfig, Base_URL } from "../../helpers/config.js";
import axios from "axios";

// define store
const authStore = useAuthStore();
const cartStore = useCartStore();

//define toast
const toast = useToast();

const data = reactive({
  coupon: {
    name: "",
  },
});

//fucntion to apply coupon
const applyCoupon = async () => {
  try {
    const response = await axios.post(
      `${Base_URL}/apply/coupon`,
      data.coupon,
      headerConfig(authStore.access_token)
    );

    if (response.data.error) {
      toast.error(response.data.error, {
        timeout: 2000,
      });
      data.coupon = {
        name: "",
      };
    } else {
      cartStore.setValidCoupon(response.data.coupon);
      cartStore.addCouponToCartItems(response.data.coupon.id);
      toast.success(response.data.message, {
        timeout: 2000,
      });
      data.coupon = {
        name: "",
      };
    }
  } catch (error) {
    console.log(error);
  }
};
</script>
<template>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="d-flex">
        <input
          v-model="data.coupon.name"
          type="text"
          placeholder="Enter coupon code"
          class="form-control rounded-0"
        />
        <button
          :disabled="!data.coupon.name"
          class="btn btn-primary rounded-0"
          @click="applyCoupon"
        >
          Apply
        </button>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
