import { defineStore } from 'pinia';
import axios from 'axios';
import { Base_URL, headerConfig } from '../helpers/config';
import { useAuthStore } from './useAuthStore';
import { useToast } from 'vue-toastification';

//define auth store
const authStore = useAuthStore()

//define toast
const toast = useToast()
export const useProductDetailStore = defineStore('product', {
    state: () => ({
        product: null,
        productThumbnail: '',
        productImages: [],
        isLoading: false,
        errorMessage: '',
        reviewToUpdata: {
            updating: false,
            data: null
        }
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


        editReview(review) {

            this.reviewToUpdata = {
                updating: true,
                data: review
            }

        },

        cancelUpdatingReview() {
            this.reviewToUpdata = {
                updating: false,
                data: null
            }
        },

        async storeReview(review) {
            try {
                this.isLoading = true;
                const response = await axios.post(`${Base_URL}/store/review`, {
                    product_id: this.product.id,
                    title: review.title,
                    body: review.body,
                    rating: review.rating,

                }, headerConfig(authStore.access_token))


                if (response.data.error) {
                    toast.error(response.data.error), {
                        timeout: 2000
                    }
                } else {
                    toast.success(response.data.message), {
                        timeout: 2000,
                    }
                }


                this.isLoading = false



            } catch (error) {
                console.log(error);
                this.isLoading = false

            }
        },
        async removeReview(review) {

            if (confirm('Are you sure you want to delete this review?')) {
                try {
                    const response = await axios.post(`${Base_URL}/delete/review`, {
                        product_id: this.product.id,
                    }, headerConfig(authStore.access_token))


                    if (response.data.error) {
                        toast.error(response.data.error), {
                            timeout: 2000
                        }
                    } else {
                        //remove the review from the product review array
                        this.product.reviews = this.product.reviews.filter((item) => item.id !== review.id)
                        toast.success(response.data.message), {
                            timeout: 2000,
                        }
                    }
                } catch (error) {
                    console.log(error);
                }
            }
        }






    }
})