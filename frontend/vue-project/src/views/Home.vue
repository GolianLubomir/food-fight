<template>
  <div>
    <DefaultLayout>
      <router-view> </router-view>
    </DefaultLayout>
    
  </div>
</template>

<script>
import DefaultLayout from '../components/DefaultLayout.vue';

export default {
  components: {
    DefaultLayout,
  },
};
</script>

<!-- Add your preferred CSS styling here -->
<style>
</style>
