import { defineStore } from 'pinia';
import axios from 'axios';
import { Base_URL } from '../helpers/config';
export const useProductStore = defineStore('products', {
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

                const response = await axios.get(`${Base_URL}/products`);

                this.products = response.data.data;
                this.categories = response.data.categories;
                this.brands = response.data.brands;
                this.sizes = response.data.sizes;
                this.colors = response.data.colors;

                this.isLoading = false;


            } catch (error) {
                console.log(error);
            }
        },

        async filterProducts(param, value, search = false) {
            try {
                this.isLoading = true;

                const response = await axios.get(`${Base_URL}/products/${value}/${param}`)

                this.products = response.data.data
                this.categories = response.data.categories
                this.brands = response.data.brands
                this.sizes = response.data.sizes
                this.colors = response.data.colors
                if (search) {
                    this.filter = {
                        param: "term",
                        value
                    }
                }
                else {
                    this.filter = {
                        param,
                        value: response.data.filter
                    }
                }
                // console.log(response.data.filter)

                this.isLoading = false;
            }

            catch (error) {
                this.isLoading = false;
                console.log(error);
            }
        },
        clearFilters() {
            this.filter = null
            this.fetchAllProducts();
        }





    },


})