<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-my">
    <div class="container-fluid">
      <router-link class="px-3" to="/"><img rel="icon" width="45" src="public/spoon-and-fork.png"></router-link>
      <router-link class="navbar-brand pr-0 " to="/">Food Fight</router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse px-5" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link " to="/">Jedálny lístok</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/api">API</router-link>
          </li>
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

<style scoped>
.bg-my{
  background-color: #f3f3f3;
}
</style>
