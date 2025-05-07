<script setup>
import { reactive } from "vue";
import { useAuthStore } from "../../stores/UseAuthStore.js";
import Alert from "../layouts/Alert.vue";
import ProfileSidebar from "./ProfileSidebar.vue";

const authStore = useAuthStore();

//define how many orders show on home.vue

const data = reactive({
  orderToShow: 6,
});

//define the function to load more products
const loadMoreOrders = () => {
  if (data.orderToShow < authStore?.user?.orders.length) {
    data.orderToShow = data.orderToShow + 4;
  } else {
    return;
  }
};
</script>

<template>
  <div class="row my-5">
    <ProfileSidebar></ProfileSidebar>

    <div class="col-md-8">
      <div class="card-body" v-if="authStore?.user?.orders.length">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Product Name</th>
              <th>Product Price</th>
              <th>Qty</th>
              <th>Total</th>
              <th>Order Date</th>
              <th>Delivered at</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(order, index) in authStore?.user?.orders.slice(
                0,
                data.orderToShow
              )"
              :key="index"
            >
              <td>{{ (index += 1) }}</td>
              <td>
                <div class="d-flex flex-column">
                  <span
                    class="badge bg-success my-1 rounded-0"
                    v-for="product in order.products"
                    :key="product.id"
                    >{{ product.name }}</span
                  >
                </div>
              </td>
              <td>
                <div class="d-flex flex-column">
                  <span
                    class="badge bg-danger my-1 rounded-0"
                    v-for="product in order.products"
                    :key="product.id"
                    >${{ product.price }}</span
                  >
                </div>
              </td>
              <td>{{ order.qty }}</td>
              <td>${{ order.total }}</td>
              <td>{{ order.created_at }}</td>
              <td>
                <span
                  class="badge bg-danger my-1 rounded-0"
                  v-if="order.delivered_at"
                  >{{ product.delivered_at }}</span
                >

                <i v-else class="text-muted">Pending....</i>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <Alert v-else content="No Orders Yet!" bgColor="primary" />
      <div class="d-flex justify-content-center">
        <button
          type="submit"
          class="btn btn-sm btn-dark mt-3"
          v-if="data.orderToShow < authStore?.user?.orders.length"
          @click="loadMoreOrders"
        >
          <i class="bi bi-arrow-clockwise"></i> Load more
        </button>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
