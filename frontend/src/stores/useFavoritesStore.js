import { defineStore } from "pinia";



export const useFavoritesStore = defineStore('favorites', {

    state: () => ({
        favorites: []

    }),
    persist: true,

    actions: {
        addToFavorites(item) {
            if (this.checkIfProductAlreadyInFavorites(item)) {

                this.favorites = this.favorites.filter(product => product.id !== item.id);
            } else {
                this.favorites.push(item);
            }
        },

        checkIfProductAlreadyInFavorites(item) {
            let index = this.favorites.findIndex(product => product.id === item.id);

            return index !== -1 ? true : false;

        },
    }


});