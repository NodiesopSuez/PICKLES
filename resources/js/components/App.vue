<template>
  <div>
  <!-- <div id="app"> -->
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

body { 
  background: var(--for-background)!important;
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
  box-shadow: 4px 4px 0px var(--shadow);
  transition: 0.1s;
}

#app button:active {
  transform: translate(3px, 4px);
  box-shadow: none; 
}

#app .fade-enter-active, 
#app .fade-leave-active {
  transition: opacity .5s;
}
#app .fade-enter, 
#app .fade-leave-to {
  opacity: 0;
}



/* modalt部分 --------------------------------------------------------- */
.modal_back {
    z-index: 20;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal_box {
    z-index: 30;
    position:absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
    padding: 16px;
    width: 330px;
    border-radius: 15px;
}

h2 {
    margin: 8px auto;
    font-weight: bold;
}

.modal_box button {
    width: 80px;
    height: 35px;
    border-radius: 17.5px;
    font-size: 18px;
    box-shadow: 3px 4px 0px #333;
}

/* statusによってモーダルの高さを分岐 */
.no_result > .modal_box {
  height: 230px;
}
.error > .modal_box,
.duplicate > .modal_box {
  height: 205px;
}
.registered > .modal_box {
  height: 168px;
}

/* モーダルの位置 */
.duplicate > .modal_box,
.registered > .modal_box {
  top: 1400px;
}
 
/* 配色：エラーの時 */
.error > .modal_back,
.no_result > .modal_back,
.duplicate > .modal_back {
    background: #2e4a32;
}
.error > .modal_box, 
.no_result > .modal_box,
.duplicate > .modal_box {
    background: #d0e2d1;
}
.error h2, 
.no_result h2,
.duplicate h2 {
    color: rgb(196, 0, 0);
}
.no_result .keyword {
  overflow: hidden;
  height: 24px;
}

/* 配色：登録完了の時 */
.registered > .modal_back {
    background: var(--for-background);
}
.registered > .modal_box {
    background: var(--md-green);
    color: #fff!important;
}
.registered h2 {
  color:#fff!important;
}
</style>
