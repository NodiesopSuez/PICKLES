import router from './router';

require('./bootstrap');

window.Vue = require('vue');


Vue.component('App', require('./components/App.vue').default);

Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));




const app = new Vue({
    el: '#app',
    router,
});