<template>
  <div class="mx-5 pt-0 bg-my-light">
    
    <div class="button-container buttons opacity-100">
      <div>
        <button v-for="(restaurant, index) in restaurants" :key="index" @click="selectedRestaurant = index+1, selectedDay = null" :class="{ active: index+1 == selectedRestaurant }" class="day-button">{{ restaurant }}</button>
      </div>
      <div class="py-5">
        <button v-for="(day, index) in days" :key="index" @click="selectedDay = index+1, selectedRestaurant = null" :class="{ active: index+1 == selectedDay }" class="day-button">{{ day }}</button>
      </div>
    </div>
    <div v-if="selectedDay != null" class="d-flex py-0 mx-auto w-100">
      <menu-component :meals="filteredKlubovnaMeals" :restaurant="'Karloveská klubovňa'"/>
      <menu-component :meals="filteredEatMeals" :restaurant="'Eat & Meet'"/>
      <menu-component :meals="filteredVenzaMeals" :restaurant="'Venza'" />
    </div>

    <div v-if="selectedRestaurant == 1" class="d-flex py-0 mx-auto w-100">
      <week-menu-component :meals="filteredKlubovnaWeekMenu" :restaurant="'Karloveská klubovňa'"/>
    </div>
    <div v-if="selectedRestaurant == 2" class="d-flex py-0 mx-auto w-100">
      <week-menu-component :meals="filteredEatWeekMenu" :restaurant="'Eat & Meet'"/>
    </div>
    <div v-if="selectedRestaurant == 3" class="d-flex py-0 mx-auto w-100">
      <week-menu-component :meals="filteredVenzaWeekMenu" :restaurant="'Venza'" />
    </div>
    
  </div>
</template>

<script>
import menuComponent from '../components/menuComponent.vue'
import WeekMenuComponent from '../components/WeekMenuComponent.vue'
import store from "../store"
import { mapGetters } from 'vuex';
//import menuComponentVue from '../components/menuComponent.vue';

export default {
  name: "WeeklyMenus",
  components:{
    menuComponent,
    WeekMenuComponent,
  },
  methods:{
    /*toggleActive() {
      this.buttons.forEach((button, i) => {
        if (i === selectedDay) {
          button.isActive = true;
        } else {
          button.isActive = false;
        }
      });
    }*/
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
        return this.meals.filter(meal => meal.restaurant_name === 'Venza' && meal.day === this.selectedDay);
    },
    filteredEatMeals() {
      return this.meals.filter(meal => meal.restaurant_name === 'Eat & Meet' && meal.day === this.selectedDay);
    },
    filteredKlubovnaMeals() {
      return this.meals.filter(meal => meal.restaurant_name === 'Karloveská klubovňa' && meal.day === this.selectedDay);
    },


    filteredVenzaWeekMenu() {
        return this.meals.filter(meal => meal.restaurant_name === 'Venza');
    },
    filteredEatWeekMenu() {
      return this.meals.filter(meal => meal.restaurant_name === 'Eat & Meet');
    },
    filteredKlubovnaWeekMenu() {
      return this.meals.filter(meal => meal.restaurant_name === 'Karloveská klubovňa');
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
      restaurants: ['Klubovňa', 'Eat & Meet', 'Venza'],
      days: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
      selectedDay: 1, 
      selectedRestaurant: null, 
    };
  },
};
</script>

<style scoped>
.bg-my-light{
  background: #ffffff;
  opacity: 0.85;
  border-radius: 50px;
}

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
  color: rgb(94, 94, 94);
  font-weight: bold;

  text-transform: uppercase;
  padding: 5px 5px 0 5px;
  width: 120px;
  margin: 0 10px;
  border: none;
  border-bottom: solid 1px #4e4e4e;
  border-radius: 10px 10px 0 0 ; 
}

.active{
  background-color: #ececec;
  color: rgb(43, 43, 43);
  border-bottom: solid 1px #fca421;
}

.day-button:hover {
  background-color: rgb(240, 240, 240);
  /*color: rgb(43, 43, 43);*/
  border-bottom: solid 1px #fca421;
}


@media (max-width: 768px) {
  .restaurant-menu {
    flex-basis: 100%;
    margin-bottom: 20px;
  }
}
</style>
