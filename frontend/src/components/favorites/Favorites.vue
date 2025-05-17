<script setup>
import { computed } from "vue";
import { useFavoritesStore } from "../../stores/useFavoritesStore";
import Alert from "../layouts/Alert.vue";
//define favorite store
const favoriteStore = useFavoritesStore();
</script>

<template>
  <div class="row my-4">
    <div class="card p-2">
      <div class="card-body" v-if="favoriteStore.favorites.length">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Image</th>
              <th>Name</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(product, index) in favoriteStore.favorites"
              :key="product.id"
            >
              <td>{{ (index += 1) }}</td>
              <td>
                <img
                  :src="product.thumbnail"
                  :alt="product.name"
                  width="60"
                  height="60"
                />
              </td>
              <td>
                <router-link :to="`product/${product.slug}`">{{
                  product.name
                }}</router-link>
              </td>
              <td>{{ product.price }}</td>

              <td>
                <i
                  class="bi bi-cart-x"
                  @click="favoriteStore.addToFavorites(product)"
                  :style="{ cursor: 'pointer' }"
                ></i>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <Alert
        bgColor="info"
        content="Your favorites list is Empty!"
        v-else
      ></Alert>
    </div>
  </div>
</template>

<style scoped></style>
