

require('./bootstrap');

window.Vue = require('vue');


Vue.component('App', require('./components/App.vue').default);



const app = new Vue({
    el: '#app',
});
