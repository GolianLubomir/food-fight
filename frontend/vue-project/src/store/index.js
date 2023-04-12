import { createStore } from 'vuex';
import axiosClient from '../axios'

const store = createStore({
  state: {

    meals: []
  },
  mutations: {
    setMeals(state, menuItems) {
      state.meals = menuItems
      console.log(state.meals)
    },
  },
  actions: {
    async fetchMenu({ commit }) {
      return axiosClient.get('/api/meals')
        .then(response => {
          commit('setMeals', response.data)
          return response;
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  getters: {
    venzaMeals: state => {
      return state.meals.filter(meal => meal.restaurant_name === 'Venza');
    },

    eatMeals: state => {
      return state.meals.filter(meal => meal.restaurant_name === 'Eat & Meet');
    },
    meals: state => {
      return state.meals
    }
  },

});

export default store;
