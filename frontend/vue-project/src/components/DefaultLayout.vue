<template>
  <div class="w-100">
    <Navbar />
    <div class="w-100">
      <p class="w-100 date">{{date}}</p>
    </div>
    
    <div class="w-100 mx-auto mt-0">
        <slot> </slot>
    </div>
    
  </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';

export default {
  components: {
    Navbar,
  },
  data() {
    const date = new Date();
    const options = { year: "numeric", month: "long", day: "numeric" };
    return {
      date: date.toLocaleDateString("sk", options),
    };
  },
};
</script>

<!-- Add your preferred CSS styling here -->
<style>
.date{
  text-align: right;
  padding: 5px;
  font-weight: 500;
}
</style>