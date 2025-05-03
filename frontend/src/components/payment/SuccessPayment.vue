<script setup>
import { useAuthStore } from "../../stores/UseAuthStore.js";
import { useCartStore } from "../../stores/UseCartStore.js";
import { Base_URL, headerConfig } from "../../helpers/config.js";
import { useToast } from "vue-toastification";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";
import { onMounted } from "vue";

const router = useRouter();
const toast = useToast();
const authStore = useAuthStore();
const cartStore = useCartStore();
const route = useRoute();

const storeUserOrder = async () => {
  try {
    const response = await axios.post(
      `${Base_URL}/store/order`,
      {
        cartItems: cartStore.cartItems,
      },
      headerConfig(authStore.access_token)
    );
    cartStore.clearCartItems();
    cartStore.setValidCoupon({
      name: "",
      discount: 0,
    });
    toast.success("Check your order status in your profile tab", {
      timeout: 2000,
    });
    authStore.user = response.data.user;
  } catch (error) {
    console.log(error);
  }
};

// ONCE THE COMPONENT IS MOUNTED WE STORE USER ORDER
onMounted(() => {
  if (cartStore.uniquehash == route.params.hash) {
    storeUserOrder();
    cartStore.setUniqueHash("");
  } else {
    router.push("/");
  }
});
</script>

<template>
  <div class="row my-5">
    <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-body p-5">
          <h4 class="text-center">Payment is done Successfully</h4>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
