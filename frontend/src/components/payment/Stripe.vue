<script setup>
import { useAuthStore } from "../../stores/UseAuthStore.js";
import { useCartStore } from "../../stores/UseCartStore.js";
import { headerConfig, makeUniqueId, Base_URL } from "../../helpers/config.js";
import axios from "axios";

const hash = makeUniqueId(24);
const authStore = useAuthStore();
const cartStore = useCartStore();

const fetchPaymentLink = async () => {
  try {
    const response = await axios.post(
      `${Base_URL}/pay/order`,
      {
        cartItems: cartStore.cartItems,
        success_url: `http://localhost:5173/#/success/payment/${hash}`,
      },
      headerConfig(authStore.access_token)
    );
    cartStore.setUniqueHash(hash);
    window.location.href = response.data.url;
  } catch (error) {
    console.log(error);
  }
};
</script>
<template>
  <div class="row">
    <div class="col-md-12">
      <button class="btn btn-dark btn-block" @click="fetchPaymentLink">
        Proceed to Payment
      </button>
    </div>
  </div>
</template>
<style scoped></style>
