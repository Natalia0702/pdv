<template>
  <img alt="logo" src="./assets/calculadoraIcon.png" class="small-image">
  <Dashboard />
</template>

<script>
import Dashboard from './components/Dashboard.vue'

export default {
  name: 'App',
  components: {
    Dashboard
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.small-image {
  max-width: 10%; 
  height: auto; 
  display: block;
  margin: auto;
}
</style>
