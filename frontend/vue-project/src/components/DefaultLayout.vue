<template>
  <div class="w-100 my-bg">
    <Navbar />
    <div class="w-100 mx-auto my-5">
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
.my-bg{
background: #ffffff;
/*background: linear-gradient(90deg, rgba(184,184,184,1) 0%, rgba(255,255,255,0.14609593837535018) 18%);*/
}
</style>