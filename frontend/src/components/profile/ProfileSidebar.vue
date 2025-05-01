<script setup>
import { useAuthStore } from "../../stores/UseAuthStore";
import { Base_URL, headerConfig } from "../../helpers/config";
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useToast } from "vue-toastification";

import Spinner from "../layouts/Spinner.vue";
import RenderValidationErrors from "../layouts/RenderValidationErrors.vue";

const authStore = useAuthStore();
const toast = useToast();
const data = reactive({
  user: {
    Image: null,
    fileInputKey: 0,
    previewUrl: null, // Store the preview URL of the image
  },
});

// Add the function to handle the file input change
const handleFileInputChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    data.user.Image = file;
    // Create a preview URL for the image
    data.user.previewUrl = URL.createObjectURL(file);
  }
};

// Update the image
const updateProfileimage = async () => {
  authStore.clearValidationErrors();
  authStore.isLoading = true;
  // Send the file
  const formData = new FormData();
  formData.append("profile_image", data.user.Image);
  formData.append("_method", "PUT");

  try {
    const response = await axios.post(
      `${Base_URL}/user/profile/update`,
      formData,
      headerConfig(authStore.access_token, "multipart/form-data")
    );

    authStore.setUser(response.data.user);
    authStore.isLoading = false;
    toast.success(response.data.message, {
      timeout: 2000,
    });

    clearFileInput(); // Clear the file input after successful upload
  } catch (error) {
    authStore.isLoading = false;
    if (error?.response?.status === 422) {
      authStore.setValidationErrors(error.response.data.errors);
    }
    console.log(error);
  }
};

// Clear input file
const clearFileInput = () => {
  data.user.Image = null;
  data.user.previewUrl = null; // Clear preview URL when input is cleared
  data.user.fileInputKey += 1; // Change the key to force re-render the input
};

onMounted(() => authStore.clearValidationErrors());
</script>

<template>
  <div class="col-md-4">
    <!-- Here the spinner -->
    <Spinner :store="authStore" />
    <!-- Here the validation error -->
    <RenderValidationErrors
      :formValidationErrors="authStore.validationErrors"
    />

    <div class="card p-2">
      <div class="d-flex flex-column justify-content-center align-items-center">
        <img
          :src="authStore.user?.profile_image"
          :alt="authStore.user?.name"
          width="150"
          height="150"
          class="rounded-circle"
        />

        <div class="input-group my-5">
          <div class="mb-3">
            <input
              type="file"
              class="form-control"
              name="image"
              id="image"
              @change="handleFileInputChange"
              :key="data.user.fileInputKey"
            />
            <!-- Image Preview -->
            <div v-if="data.user.previewUrl">
              <img
                :src="data.user.previewUrl"
                alt="Preview"
                width="50"
                height="50"
                class="rounded-circle mt-3"
              />
            </div>
            <button
              type="submit"
              class="btn btn-sm btn-dark mt-2"
              @click="updateProfileimage"
            >
              Submit
            </button>
          </div>

          <ul class="list-group w-100 text-center mt-2">
            <li class="list-group-item">
              <i class="bi bi-person"> {{ authStore.user?.name }}</i>
            </li>
            <li class="list-group-item">
              <i class="bi bi-envelope-at-fill"> {{ authStore.user?.email }}</i>
            </li>
            <li class="list-group-item">
              <router-link
                to="/user/orders"
                class="text-decoration-none text-dark"
              >
                <i class="bi bi-bag-check-fill"> Orders</i>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
