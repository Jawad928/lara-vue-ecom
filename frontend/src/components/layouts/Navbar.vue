<script setup>
import { useCartStore } from "../../stores/useCartStore";
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/UseAuthStore";
import { headerConfig, Base_URL } from "../../helpers/config.js";
import { useToast } from "vue-toastification";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const authStore = useAuthStore();
//toaster
const toast = useToast();

//define cartStore
const cartStore = useCartStore();

//logout function
const userLogout = async () => {
  try {
    const response = await axios.post(
      `${Base_URL}/user/logout`,
      null,
      headerConfig(authStore.access_token)
    );
    authStore.clearAuthData();
    toast.success(response.data.message, {
      timeout: 2000,
    });

    router.push("/login");
  } catch (error) {
    console.log(error);
  }
};
//fetch the currently logged in user
//and check if the accesc toke is valid
const fetchCurrentUser = async () => {
  try {
    const response = await axios.get(
      `${Base_URL}/user`,
      headerConfig(authStore.access_token)
    );

    authStore.setIsLoggedIn();
    authStore.setUser(response.data.user);
    authStore.setToken(response.data.access_token);
  } catch (error) {
    if (error?.response?.status === 401) {
      authStore.clearAuthData();
    }
    console.log(error);
  }
};

//once the component is loaded we get the currenttly logged in user
onMounted(() => {
  authStore.isLoggedIn && fetchCurrentUser();
});
</script>

<template>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <router-link class="navbar-brand" to="/">
        <img
          src="https://cdn.pixabay.com/photo/2014/04/02/11/16/shopping-305728_1280.png"
          alt="Logo"
          width="60"
          height="60"
        />
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link active" aria-current="page" to="/">
              <i class="bi bi-house-door-fill"></i> Home
            </router-link>
          </li>

          <ul class="nav-bar nav" v-if="!authStore.isLoggedIn">
            <li class="nav-item">
              <router-link class="nav-link active" to="/register">
                <i class="bi bi-person-add"></i> Register</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link active" to="/login">
                <i class="bi bi-box-arrow-right"></i> Login</router-link
              >
            </li>
          </ul>
          <ul class="nav-bar nav" v-else>
            <li class="nav-item">
              <router-link class="nav-link active" to="/profile">
                <i class="bi bi-person-add"></i>
                {{ authStore.user.name }}</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link active" @click="userLogout()" to="#">
                <i class="bi bi-box-arrow-left"></i> Logout</router-link
              >
            </li>
          </ul>

          <li class="nav-item">
            <router-link class="nav-link active" to="/cart">
              <i class="bi bi-cart-plus"></i> Cart({{
                cartStore.cartItems.length
              }})</router-link
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.navbar a {
  font-size: 1.1rem;
  font-weight: 700;
}
</style>
