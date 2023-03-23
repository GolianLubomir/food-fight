<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <router-link class="navbar-brand px-3" to="/">Zadanie 2</router-link>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Jedálny lístok</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/apidescription">Popis API</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/api">API</router-link>
          </li>
          <!-- Add more links here as needed -->
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navbar',
};
</script>

<!-- Add your preferred CSS styling here -->
<style scoped>
</style>
