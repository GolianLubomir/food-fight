<template>
  <div class="w-100">
    <h4 class="menu-header">{{ restaurant }}  </h4>
    <ul class="menu">
      <li class="meal" v-for="meal in meals" :key="meal.name">
        <h5> {{ meal.menu }} </h5>
        <p class="mb-0 font-weight-bold"> {{ meal.name }}  </p> 
        <p>  {{ meal.price }} </p>
      </li>
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
    color: #585858;
    width: 80%;
    min-width: 150px;
    border-bottom: 1px solid #8b8b8b;
    margin: 0 auto 20px auto;
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
    margin: 15px auto
}
</style>