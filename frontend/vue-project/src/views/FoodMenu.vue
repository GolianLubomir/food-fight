<template>
  <div class="mx-5 ">
    <div class="button-container buttons">
      <button v-for="(day, index) in days" :key="index" @click="selectedDay = index+1" class="day-button">{{ day }}</button>
    </div>
    <div class="d-flex py-5 mx-auto w-75">
      <menu-component :meals="filteredVenzaMeals" :restaurant="'Venza'" />
      <menu-component :meals="filteredEatMeals" :restaurant="'Eat & Meet'"/>
    </div>
    
  </div>
</template>

<script>
import menuComponent from '../components/menuComponent.vue'
import store from "../store"
import { mapGetters } from 'vuex';
//import menuComponentVue from '../components/menuComponent.vue';

export default {
  name: "WeeklyMenus",
  components:{
    menuComponent,
  },
  computed: {
    ...mapGetters(['venzaMeals', 'meals', 'eatMeals']),
    computedData() {
      return this.data[this.selectedDay];
    },
    filteredMeals() {
        return this.venzaMeals.filter(meal => meal.day === this.selectedDay);
    },
    filteredVenzaMeals() {
        return this.venzaMeals.filter(meal => meal.restaurant_name === 'Venza' && meal.day === this.selectedDay);
    },
    filteredEatMeals() {
      return this.eatMeals.filter(meal => meal.restaurant_name === 'Eat & Meet' && meal.day === this.selectedDay);
    },


  },
  mounted(){
    console.log("Mounted...")
    console.log(store.state.meals.length)
    if (store.state.meals.length == 0){
      store.dispatch('fetchMenu')
      console.log("Meals were fetched.")
    }else{
      console.log("Meals are already fetched.") 
    }
    
  },
  data() {
    return {
      days: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
      selectedDay: 1,
      data: {
        Monday: 10,
        Tuesday: 20,
        Wednesday: 30,
        Thursday: 40,
        Friday: 50,
        Saturday: 60,
        Sunday: 70,
      },
      
    };
  },
};
</script>

<style scoped>
.weekly-menus {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.restaurant-menu {
  flex-basis: calc(33% - 20px);
  margin-bottom: 20px;
  /*background-color: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 4px;*/
  padding: 10px;
  text-align: center;
}

.menu {
 
  flex-wrap: wrap;
  justify-content: space-between;
}

.menu-day {
  flex-basis: calc(33% - 10px);
  margin-bottom: 10px;
  text-align: left;
}

.buttons{
  width: fit-content;
  margin: 0 auto 40px auto;
  padding: 0 0 0px 0;
  text-align: center;
  border-bottom: solid 0px #4e4e4e;
}

.day-button{
  background-color: #ffffff;
  font-size: 18px;
  color: rgb(142, 146, 142);
  font-weight: bold;

  text-transform: uppercase;
  padding: 5px 5px 0 5px;
  width: 120px;
  margin: 0 10px;
  border: none;
  border-bottom: solid 1px #4e4e4e;
  border-radius: 10px 10px 0 0 ; 
}

.day-button:hover {
  background-color: rgb(240, 240, 240);
  color: rgb(43, 43, 43);
  border-bottom: solid 1px #fca421;
}


@media (max-width: 768px) {
  .restaurant-menu {
    flex-basis: 100%;
    margin-bottom: 20px;
  }
}
</style>
