import { defineStore } from 'pinia';
import axios from 'axios';
import { Base_URL } from '../helpers/config';


export const useProductDetailStore = defineStore('product', {
    state: () => ({
        product: null,
        productThumbnail: '',
        productImages: [],
        is_loading: false,
        errorMessage: ''
    }),
    actions: {
        async fetchAllProducts(slug) {
            try {
                this.isLoading = true;
                this.product = null;
                this.productImages = [];

                const response = await axios.get(`${Base_URL}/products/${slug}/show`);
                this.product = response.data.data
                this.productThumbnail = response.data.data.thumbnail

                //add product images to array
                if (response.data.data.first_image) {
                    this.productImages.push({
                        id: 1,
                        src: response.data.data.first_image
                    })
                }
                if (response.data.data.second_image) {
                    this.productImages.push({
                        id: 2,
                        src: response.data.data.second_image
                    })
                }
                if (response.data.data.third_image) {
                    this.productImages.push({
                        id: 3,
                        src: response.data.data.third_image
                    })
                }


                this.isLoading = false;


            } catch (error) {
                this.isLoading = false;
                console.log(error);
            }
        },
    }
})