import { defineStore } from 'pinia';
import { useToast } from "vue-toastification";
//define toast
const toast = useToast();

export const useCartStore = defineStore('cart', {

    state: () => ({
        cartItems: [],
        validCoupon: {
            name: "",
            discount: 0,
        },
        uniquehash: ""

    }),
    persist: true,
    actions: {
        addToCart(item) {
            let index = this.cartItems.findIndex(Product => Product.product_id === item.product_id && Product.color === item.color && Product.size === item.size);

            if (index !== -1) {
                toast.info("Product already in Cart", {
                    timeout: 2000
                });
            } else if (item.qty > item.maxQty) {
                toast.error(` Only ${item.maxQty} available`, {
                    timeout: 2000
                });
            }
            else {
                this.cartItems.push(item)
                toast.success("Product added to your Cart", {
                    timeout: 2000
                });
            }
        },
        incrementQty(item) {
            let index = this.cartItems.findIndex(Product => Product.product_id === item.product_id && Product.color === item.color && Product.size === item.size);
            //if product exist
            if (index !== -1) {
                if (this.cartItems[index].qty == item.maxQty) {
                    toast.success(` Only ${item.qty} available`, {
                        timeout: 2000
                    });
                } else {
                    this.cartItems[index].qty += 1;
                }
            }
        },
        decrementQty(item) {
            let index = this.cartItems.findIndex(Product => Product.product_id === item.product_id && Product.color === item.color && Product.size === item.size);
            //if product exist
            if (index !== -1) {
                this.cartItems[index].qty -= 1;
                if (this.cartItems[index].qty == 0) {
                    this.cartItems = this.cartItems.filter(Product => Product.ref !== item.ref)
                } else {

                }
            }
        },

        removeFromCart(item) {
            this.cartItems = this.cartItems.filter(Product => Product.ref !== item.ref)
            toast.success("Product removed from your Cart", {
                timeout: 2000
            });
        },


        clearCartItems() { this.cartItems = [] },

        setValidCoupon(coupon) {
            this.validCoupon = coupon
        },


        addCouponToCartItems(coupon_id) {
            this.cartItems = this.cartItems.map(item => {
                return { ...item, coupon_id }

            });
        }
        ,

        setUniqueHash(hash) {
            this.uniquehash = hash
        },









    }
})