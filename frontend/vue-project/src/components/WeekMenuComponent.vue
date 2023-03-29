<template>
  <div class="w-100">
    <h4 class="menu-header-week">{{ restaurant }}  </h4>
    <div class="">
        <div class=" w-75 mx-auto" v-for="(mealDay, index) in days" :key="mealDay.day">
            <div class="menu-day-header">
                <h4 class="px-5 my-1"> {{mealDay}}</h4>
            </div>
            <ul class="menu ">
                <div v-for="meal in meals" :key="meal.name" class="">
                    <li v-if="index+1 == meal.day" class="meal-week d-flex" >
                        <h5 class="meal-header"> {{ meal.menu }} </h5>
                        <p class="mb-0 font-weight-bold meal-text"> {{ meal.name }}  </p> 
                        <p class="meal-price">  {{ meal.price }} </p>
                    </li>
                </div>
            </ul>
        </div>
    </div>
    
  </div>
</template>

<script>
  export default {
    props: {
      meals: {
        type: Array,
        required: true,
      },
      restaurant: {
        type: String,
        required: true,
      },
      
    },

    data() {
    return {
      restaurants: ['Klubovňa', 'Eat & Meet', 'Venza'],
      days: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"], 
    };
  },
  };
</script>

<style>
.menu-header-week{
    text-align: center;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    /*font-family: 'Poppins';*/
    color: #585858;
    width: 80%;
    min-width: 150px;
    height: 65px;
    align-items: center;
    display: flex;
    justify-content: center;
    border-bottom: 1px solid #8b8b8b;
    margin: 0 auto 20px auto;
}

.menu{
    text-decoration: none;
    list-style: none;
    text-align: center;
    padding: 0;

    
}

.meal-week{
    border-bottom: 1px solid #aaa;
    
    height: 50px;
    margin: 15px auto;
    justify-content: space-between;
}
.meal-header{
    width: 100px;
}

.meal-text{

}

.meal-price{

}

.menu-day-header{
    background: #ffd699;
    border-radius: 20px;
    padding: 1px;

}


</style>