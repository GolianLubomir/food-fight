import { createStore } from 'vuex';
import axiosClient from '../axios'

const store = createStore({
  state: {

    meals: []
  },
  mutations: {
    setMeals(state, menuItems) {

      /*menuItems.forEach(item =>{
        const arrayItem = {
          menu: item.menu,
          meal_name: item.name,
          price: item.price,
          restaurant_name: item.restaurant_name,
          day: item.day,
          src_image: item.src_image
        };
        state.meals.push(arrayItem) 
      })*/


      state.meals = menuItems
      console.log(state.meals)
    },
  },
  actions: {
    async fetchMenu({ commit }) {
      /*const response = await axiosClient.get('/api/meals')
      try{
        const menuItems = JSON.parse(response.data)
        commit('setMeals', menuItems)
      }catch (error){
        console.log(`Error parsing JSON: ${error}`);
      }*/
      return axiosClient.get('/api/meals')
        .then(response => {
          //const meals = response.data;
          commit('setMeals', response.data)
          //console.log(meals); // Output the meals object to the console
          return response;
        })
        .catch(error => {
          console.log(error);
        });
      //commit('setMeals', menuItems)
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
