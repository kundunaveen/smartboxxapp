import Vue from "vue";
import Router from "vue-router";
import Login from './components/pages/Login.vue'
import Dashboard from './components/pages/Dashboard.vue'
import Forgot from './components/pages/Forgot.vue'

Vue.use(Router)

export default new Router({
    mode:'history',
    routes:[
        {
            path:'/',component:Login
        },
        {
            path:'/dashboard',component:Dashboard
        },
        {
            path:'/forgot',component:Forgot
        }
    ]
})