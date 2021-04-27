import Vue from 'vue'
import VueRouter from 'vue-router'
import Top from './components/Top.vue'
import Example from './components/ExampleComponent.vue'
import Recommends from './components/Recommends.vue'
import SignUp from './components/SignUp.vue'
import Login from './components/Login.vue'

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',

    routes: [
        { path:'/', component:Top },
        { path:'/example', component:Example },
        { path:'/recommends', component:Recommends },
        { path:'/signup', component:SignUp },
        { path:'/login', component:Login },
        { path:`/user/:user_id`, component:Top}
    ]
});