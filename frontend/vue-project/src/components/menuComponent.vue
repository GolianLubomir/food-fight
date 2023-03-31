<template>
  <div class="w-100">
    <h4 class="menu-header">{{ restaurant }}  </h4>
    <ul class="menu">
      <div v-for="meal in meals" :key="meal.name" class="meal-div">
        <li class="meal" >
          <h5> {{ meal.menu }} </h5>
          <p class="mb-0 font-weight-bold"> {{ meal.name }}  </p> 
          <p class="price">  {{ meal.price }} </p>
        </li>
      </div>
      <div v-if="meals.length == 0"  class="meal-div">
        <li class="meal" >
          <h5> </h5>
          <p class="mb-0 ">   </p> 
          <p class="price">  Reštaurácia v daný deň nevarí. </p>
        </li>
      </div>
    </ul>
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
  };
</script>

<style>
.menu-header{
    text-align: center;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    /*font-family: 'Poppins';*/
    color: #333333;
    width: 90%;
    min-width: 150px;
    height: 65px;
    align-items: center;
    display: flex;
    justify-content: center;
    /*border-bottom: 1px solid #8b8b8b;*/
    margin: 0 auto 0px auto;
    background: #ffd9a0;
    border-radius: 20px 20px 0 0;
}  

.menu{
    text-decoration: none;
    list-style: none;
    text-align: center;
    padding: 0;
    width: 90%;
    margin: 0 auto 50px auto;
    /*border-right: 1px solid #a5a5a5;
    border-left: 1px solid #a5a5a5;
    border-bottom: 1px solid #a5a5a5;*/
    background: #fff9f0;
    border-radius:   0 0 5px 5px;
}

.meal{
    border-bottom: 2px solid #89b1e6;
    border-bottom: 2px solid #89b1e6;
    width: 80%;
    margin: 15px auto;
    
}

.price{
  font-weight: 500;
}

.meal-div{
  display: flex;
    justify-content: center;
    height: 150px;
}

@media (max-width: 1300px) {
  .meal-div{
      height: 175px;
  }

}

@media (max-width: 880px) {
  .meal-div{
      height: 200px;
  }

}

@media (max-width: 680px) {
  .meal-div{
      height: 220px;
  }

}

@media (max-width: 580px) {
  .meal-div{
      height: 150px;
  }
  .meal{
    width: 100%;
    
    margin: 15px auto;

}

}
</style>