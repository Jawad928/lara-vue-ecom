import { defineStore } from 'pinia';
import axios from 'axios';
export const useProductStore = defineStore('counter', {
    state: () => ({
        products: [],
        categories: [],
        brands: [],
        sizes: [],
        colors: [],
        isLoading: false,
        filter: null,
    }),

    actions: {
        async fetchAllProducts() {
            try {
                this.isLoading = true;

                const response = await axios.get('http://127.0.0.1:8000/api/products  ');

                this.products = response.data.data;
                this.categories = response.data.categories;
                this.brands = response.data.brands;
                this.sizes = response.data.sizes;
                this.colors = response.data.colors;

                this.isLoading = false;


            } catch (error) {
                console.log(error);
            }
        }
    },
})