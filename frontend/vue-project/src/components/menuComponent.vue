<template>
  <div class="w-100">
    <h4 class="menu-header">{{ restaurant }}  </h4>
    <ul class="menu">
      <div v-for="meal in meals" :key="meal.name" class="meal-div">
        <li class="meal" >
          <h5> {{ meal.menu }} </h5>
          <p class="mb-0 font-weight-bold"> {{ meal.name }}  </p> 
          <p>  {{ meal.price }} </p>
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
    color: #585858;
    width: 80%;
    min-width: 150px;
    height: 65px;
    align-items: center;
    display: flex;
    justify-content: center;
    border-bottom: 1px solid #8b8b8b;
    margin: 0 auto 20px auto;
    background: #ffd699;
    border-radius: 20px 20px 0 0;
}  

.menu{
    text-decoration: none;
    list-style: none;
    text-align: center;
    padding: 0;
}

.meal{
    border-bottom: 1px solid #aaa;
    width: 70%;
    
    margin: 15px auto;

}

.meal-div{
  display: flex;
    justify-content: center;
    height: 150px;
}
</style>