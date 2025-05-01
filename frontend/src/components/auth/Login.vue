<script setup>
import { useAuthStore } from "../../stores/UseAuthStore.js";
import { onMounted, reactive } from "vue";
import { useToast } from "vue-toastification";
import { Base_URL } from "../../helpers/config.js";
import Spinner from "../layouts/Spinner.vue";

import { useRouter } from "vue-router";
import axios from "axios";
import RenderValidationErrors from "../layouts/RenderValidationErrors.vue";

//define toast
const toast = useToast();
const router = useRouter();

const authStore = useAuthStore();

const data = reactive({
  user: {
    email: "",
    password: "",
  },
});

//register user

const loginUser = async () => {
  authStore.clearValidationErrors();
  authStore.isLoading = true;
  try {
    const response = await axios.post(`${Base_URL}/user/login`, data.user);

    authStore.isLoading = false;

    if (response.data.error) {
      toast.error(response.data.error, {
        timeout: 2000,
      });
    } else {
      authStore.setIsLoggedIn();
      authStore.setUser(response.data.user);
      authStore.setToken(response.data.access_token);
      toast.success(response.data.message, {
        timeout: 2000,
      });
      router.push("/");
    }
  } catch (error) {
    authStore.isLoading = false;
    if (error?.response?.status === 422) {
      authStore.setValidationErrors(error.response.data.errors);
    }
    console.log(error);
  }
};

onMounted(() => {
  authStore.clearValidationErrors();
});
</script>

<template>
  <div class="row my-5">
    <!-- here is the spinner -->
    <Spinner :store="authStore" />
    <div class="col-md-5 mx-auto">
      <!-- render validation error -->
      <RenderValidationErrors
        :formValidationErrors="authStore.validationErrors"
      ></RenderValidationErrors>

      <div class="card rounded-0 shadow-sm">
        <div class="card-header bg-white">
          <h5 class="text-center mt-2">Login</h5>
        </div>

        <div class="card-body">
          <form @submit.prevent="loginUser">
            <div class="mb-3">
              <label for="email" class="form-label">Email*</label>
              <input
                type="email"
                class="form-control"
                v-model="data.user.email"
                name="email"
                id="email"
                aria-describedby="helpId"
                placeholder="Email*"
              />
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password*</label>
              <input
                type="password"
                class="form-control"
                v-model="data.user.password"
                name="password"
                id="password"
                aria-describedby="helpId"
                placeholder="Password*"
              />
            </div>

            <div class="mb-3">
              <button type="submit" class="btn btn-sm btn-dark rounded-0">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
