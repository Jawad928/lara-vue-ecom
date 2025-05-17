import { createRouter, createWebHashHistory } from 'vue-router'
const Home = () => import('../components/Home.vue')
const Register = () => import('../components/auth/Register.vue')
const Login = () => import('../components/auth/Login.vue')
const Product = () => import('../components/products/Product.vue')
const Cart = () => import('../components/cart/Cart.vue')
const Profile = () => import('../components/profile/Profile.vue')
const Checkout = () => import('../components/checkout/checkout.vue')
const SuccessPayment = () => import('../components/payment/SuccessPayment.vue')
const UserOrders = () => import('../components/profile/UserOrder.vue')
const Favorites = () => import('../components/favorites/Favorites.vue')

import { useAuthStore } from "../stores/UseAuthStore.js";

// add route guards to check if user is logged in and redirect to login page if not
function checkIfUserIsLoggedIn() {
    const authStore = useAuthStore()
    if (!authStore.isLoggedIn) return '/login'

}
function checkIfUserIsNotLoggedIn() {
    const authStore = useAuthStore()
    if (authStore.isLoggedIn) return '/'

}

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            beforeEnter: [checkIfUserIsNotLoggedIn]
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: [checkIfUserIsNotLoggedIn]
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/checkout',
            name: 'checkout',
            component: Checkout,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/success/payment/:hash',
            name: 'successPayment',
            component: SuccessPayment,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/user/orders',
            name: 'userOrders',
            component: UserOrders,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/product/:slug',
            name: 'product',
            component: Product
        },
        {
            path: '/cart',
            name: 'cart',
            component: Cart
        },
        {
            path: '/favorites',
            name: 'favorites',
            component: Favorites
        },
    ]
})
export default router
