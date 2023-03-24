import { createStore } from 'vuex';
import axiosClient from '../axios'

const store = createStore({
  state: {

    meals: []
  },
  mutations: {
    setMeals(state, menuItems) {
      state.meals = menuItems
    },
  },
  actions: {
    async fetchMenu({ commit }) {
      const response = await axiosClient.get('/api/meals')
      const menuItems = response.data
      commit('setMeals', menuItems)
    },
  },
  getters: {
    // Your getter functions go here
  },
});

export default store;
