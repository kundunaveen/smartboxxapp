import Vue from "vue";
import Router from "vue-router";
import Login from './components/pages/Login.vue'
import Dashboard from './components/pages/Dashboard.vue'
import Forgot from './components/pages/Forgot.vue'
import Users from './components/pages/Users.vue'
import Booking from './components/pages/Booking.vue'
import AddUser from './components/pages/AddUser.vue'
import EditUser from './components/pages/EditUser.vue'
import ChangePass from './components/pages/ChangePass.vue'
import AddBooking from './components/pages/Booking/AddBooking.vue'
import EditBooking from './components/pages/Booking/EditBooking.vue'




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
        },
        {
            path:'/users',component:Users
        },
        {
            path:'/booking',component:Booking
        },
        {
            path:'/add-user',component:AddUser
        },
        {
            path:'/add-booking',component:AddBooking
        },
        {
            name: 'edit',
            path: '/edit/:id',
            component: EditUser
        },
        {
            name: 'pass',
            path: '/change_pass/:id',
            component: ChangePass
        },
        {
            name: 'bookingedit',
            path: '/booking-edit/:id',
            component: EditBooking
        },
        
        
    ]
})