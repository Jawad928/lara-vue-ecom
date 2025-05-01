<script setup>
import { useAuthStore } from "../../stores/UseAuthStore";
import { onMounted, reactive } from "vue";
import { Base_URL, headerConfig } from "../../helpers/config";
import { useToast } from "vue-toastification";
import axios from "axios";

//define the toaster
const toast = useToast();
//define the auth store
const authStore = useAuthStore();

const data = reactive({
  userCurrentInfo: {
    phone_number: "",
    address: "",
    city: "",
    country: "",
    zip_code: "",
  },
});

// Update the User Info
const updateUserInfos = async () => {
  authStore.isLoading = true;

  const userData = {
    phone_number: data.userCurrentInfo.phone_number,
    address: data.userCurrentInfo.address,
    city: data.userCurrentInfo.city,
    country: data.userCurrentInfo.country,
    zip_code: data.userCurrentInfo.zip_code,
  };

  try {
    const response = await axios.put(
      `${Base_URL}/user/profile/update`,
      userData,
      headerConfig(authStore.access_token)
    );

    authStore.setUser(response.data.user);
    authStore.isLoading = false;
    toast.success(response.data.message, {
      timeout: 2000,
    });
  } catch (error) {
    authStore.isLoading = false;
    console.log(error);
  }
};

const props = defineProps({
  updatingProfile: {
    type: Boolean,
    default: false,
    required: false,
  },
});

// fill the form with the user information
onMounted(() => {
  data.userCurrentInfo = authStore.user;
});
</script>

<template>
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-header bg-white">
        <h5 class="text-center my-2">
          {{ updatingProfile ? "User Details" : "Billing Details" }}
        </h5>
      </div>

      <div class="card-body">
        <form class="mt-5" @submit.prevent="updateUserInfos">
          <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number*</label>
            <input
              :required="true"
              type="number"
              class="form-control"
              v-model="data.userCurrentInfo.phone_number"
              name="phone_number"
              id="phone_number"
              aria-describedby="helpId"
              placeholder="Phone number*"
            />
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Address*</label>
            <input
              :required="true"
              type="text"
              class="form-control"
              v-model="data.userCurrentInfo.address"
              name="address"
              id="address"
              aria-describedby="helpId"
              placeholder="Address*"
            />
          </div>

          <div class="mb-3">
            <label for="zip_code" class="form-label">Zip Code*</label>
            <input
              :required="true"
              type="text"
              class="form-control"
              v-model="data.userCurrentInfo.zip_code"
              name="zip_code"
              id="zip_code"
              aria-describedby="helpId"
              placeholder="Zip Code*"
            />
          </div>
          <div class="mb-3">
            <label for="city" class="form-label">City*</label>
            <input
              :required="true"
              type="text"
              class="form-control"
              v-model="data.userCurrentInfo.city"
              name="city"
              id="city"
              aria-describedby="helpId"
              placeholder="City*"
            />
          </div>
          <div class="mb-3">
            <label for="country" class="form-label">Country*</label>
            <input
              :required="true"
              type="text"
              class="form-control"
              v-model="data.userCurrentInfo.country"
              name="country"
              id="country"
              aria-describedby="helpId"
              placeholder="Country*"
            />
          </div>

          <div class="mb-3">
            <button
              v-if="!authStore.user.profile_completed || updatingProfile"
              type="submit"
              class="btn btn-sm btn-dark rounded-0"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
