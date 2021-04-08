import Vue from 'vue'
import VueRouter from 'vue-router'
import Top from './components/Top.vue'
import Example from './components/ExampleComponent.vue'

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',

    routes: [
        { path:'/', component:Top },
        { path:'/example', component:Example },
    ]
});