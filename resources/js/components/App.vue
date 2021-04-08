<template>
  <div id="app">
    <!-- <div class="container"> -->
       <transition name="fade" mode="out-in"><router-view></router-view></transition>
    <!-- </div> -->
  </div>
</template>

<script>
import Top from './Top.vue'

export default {
  name: 'App',
    components: {
    Top,
  } 
}
</script>

<style>
:root {
  --lt-yellow: #FFE959;
  --md-yellow: #FFCD03;
  --hv-yellow: #ff8000;
  --for-background: #C8FFD3;
  --icon-background: #FDD441;
  --md-green: #00502E;
  --shadow: #B4CF8F;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#app button {
  margin: auto;
  border: none;
  outline: none;
  text-align: center;
}

#app li {
  list-style: none;
}

#app button {
  cursor: pointer;
  box-shadow: 3px 4px 0px var(--hv-yellow);
  transition: 0.1s;
}

#app button:active {
  transform: translate(3px, 4px);
  box-shadow: none; 
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
