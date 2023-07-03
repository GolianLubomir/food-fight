<template>
  <div class="mx-2 pt-0 bg-my-light">
    
    <div class="button-container buttons opacity-100">
      <div class="pb-3">
        <button v-for="(restaurant, index) in restaurants" :key="index" @click="selectedRestaurant = index+1, selectedDay = null" :class="{ active: index+1 == selectedRestaurant }" class="button-55">{{ restaurant }}</button>
      </div>
      <div class="py-2">
        <button v-for="(day, index) in days" :key="index" @click="selectedDay = index+1, selectedRestaurant = null" :class="{ active: index+1 == selectedDay }" class="button-55 ">{{ day }}</button>
      </div>
    </div>
    <div></div>
    <p class="text-center selected-date">{{selectedDate}}</p>
    <div v-if="selectedDay != null" class="py-0 mx-auto w-100 menus">
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

export default {
  name: "WeeklyMenus",
  components:{
    menuComponent,
    WeekMenuComponent,
  },
  methods:{

  },
  computed: {
    ...mapGetters(['venzaMeals', 'meals', 'eatMeals']),
    selectedDate() {
      const date = new Date();
      const currentDay = date.getDay();
      date.setDate(date.getDate() + (this.selectedDay - currentDay));
      const options = { year: "numeric", month: "long", day: "numeric" };
      return date.toLocaleDateString("sk", options);
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
    const date = new Date();
    const options = { year: "numeric", month: "long", day: "numeric" };
    const dayOfWeek = date.getDay() == 0 ? 7 : date.getDay();
    
    return {
      restaurants: ['Klubovňa', 'Eat & Meet', 'Venza'],
      //days: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
      days: ["Pondelok", "Utorok", "Streda", "Štvrtok", "Piatok", "Sobota", "Nedeľa"],
      selectedDay: dayOfWeek, 
      selectedRestaurant: null, 
      date: date.toLocaleDateString("sk", options),
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

.selected-date{
  background: #a5e3f7;
  font-weight: 500;
  width: 200px;
  margin: 10px auto 30px auto;
  border-radius: 50px;
  padding: 2px 0;
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

.menus{
  display: flex;
}

.buttons{
  width: fit-content;
  margin: 0 auto 0px auto;
  padding: 0 0 0px 0;
  text-align: center;
  border-bottom: solid 0px #4e4e4e;
}

.button-55 {
  width: 120px;
  margin: 10px 10px;
  align-self: center;
  background-color: #fff;
  background-image: none;
  background-position: 0 90%;
  background-repeat: repeat no-repeat;
  background-size: 4px 3px;
  border-radius: 15px 225px 255px 15px 15px 255px 225px 15px;
  border-style: solid;
  border-width: 2px;
  box-shadow: rgba(0, 0, 0, .2) 15px 28px 25px -18px;
  box-sizing: border-box;
  color: #41403e;
  cursor: pointer;
  display: inline-block;
  font-family: Neucha, sans-serif;
  font-size: 1rem;
  font-weight: 500;
  letter-spacing: 1px;
  white-space: nowrap;
  line-height: 23px;
  outline: none;
  padding: .75rem;
  text-decoration: none;
  transition: all 235ms ease-in-out;
  border-bottom-left-radius: 15px 255px;
  border-bottom-right-radius: 225px 15px;
  border-top-left-radius: 255px 15px;
  border-top-right-radius: 15px 225px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-55:hover {
  box-shadow: rgba(0, 0, 0, .3) 2px 8px 8px -5px;
  transform: translate3d(0, 2px, 0);
}

.button-55:focus {
  box-shadow: rgba(0, 0, 0, .3) 2px 8px 4px -6px;
}

.active{
  background-color: #a5e3f7;
  color: rgb(37, 37, 37);
  font-weight: 700;
}

@media (max-width: 768px) {
  .restaurant-menu {
    flex-basis: 100%;
    margin-bottom: 20px;
  }
}

@media (max-width: 580px) {
 .menus{
  display: inline;
 }

 .button-55{
  width: 100px;
  font-size: 0.8rem;
  padding: .4rem;
  margin: 5px 5px;
 }

 @media (max-width: 450px) {


  .button-55{
    width: 80px;
    font-size: 0.7rem;
  }
 }
}
</style>
