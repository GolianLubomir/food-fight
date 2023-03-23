<template>
  <div class="w-100">
    <Navbar />
    <div class="w-75 mx-auto my-5">
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
};
</script>

<!-- Add your preferred CSS styling here -->
<style>
</style>