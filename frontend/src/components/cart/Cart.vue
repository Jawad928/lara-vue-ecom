<script setup>
import { computed } from "vue";
import { useCartStore } from "../../stores/useCartStore";
import Alert from "../layouts/Alert.vue";
//define cartStore
const cartStore = useCartStore();

//calculate the total price of the cart
const total = computed(() =>
  cartStore.cartItems.reduce((acc, item) => (acc += item.price * item.qty), 0)
);
</script>

<template>
  <div class="row my-4">
    <div class="card p-2">
      <div class="card-body" v-if="cartStore.cartItems.length">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Image</th>
              <th>Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Color</th>
              <th>Size</th>
              <th>SubTotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(product, index) in cartStore.cartItems"
              :key="product.ref"
            >
              <td>{{ (index += 1) }}</td>
              <td>
                <img
                  :src="product.image"
                  :alt="product.name"
                  width="60"
                  height="60"
                />
              </td>
              <td>{{ product.name }}</td>
              <td>
                <i
                  class="bi bi-caret-up"
                  @click="cartStore.incrementQty(product)"
                  :style="{ cursor: 'pointer' }"
                ></i>

                <span class="mx-2"> {{ product.qty }}</span>

                <i
                  class="bi bi-caret-down"
                  @click="cartStore.decrementQty(product)"
                  :style="{ cursor: 'pointer' }"
                ></i>
              </td>
              <td>${{ product.price }}</td>
              <td>
                <div
                  class="border border-light-subtle border-2"
                  :style="{
                    backgroundColor: product.color,
                    width: ' 25px',
                    height: '25px',
                    borderRadius: '30%',
                  }"
                ></div>
              </td>
              <td>
                <span class="bg-light text-dark me-2 p-1 fw-bold">
                  <small>{{ product.size }}</small>
                </span>
              </td>

              <td>${{ product.qty * product.price }}</td>
              <td>
                <i
                  class="bi bi-cart-x"
                  @click="cartStore.removeFromCart(product)"
                  :style="{ cursor: 'pointer' }"
                ></i>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <div class="border border-dark border-3 fw-bold p-2 rounded">
            Total:<span class="text-danger"> $ {{ total }} </span>
          </div>
        </div>
      </div>
      <Alert bgColor="info" content="Your Cart is Empty!" v-else></Alert>

      <div class="d-flex justify-content-end my-3">
        <router-link to="/" class="btn btn-dark rounded-1 mx-2">
          Continue Shopping
        </router-link>

        <router-link
          to="/checkout"
          class="btn btn-danger rounded-1 mx-2"
          v-if="cartStore.cartItems.length"
          >Checkout</router-link
        >
      </div>
    </div>
  </div>
</template>

<style scoped></style>
