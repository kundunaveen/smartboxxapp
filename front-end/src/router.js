import Vue from "vue";
import Router from "vue-router";
import Login from './components/pages/Login.vue'
import Dashboard from './components/pages/Dashboard.vue'
import Forgot from './components/pages/Forgot.vue'
import Users from './components/pages/Users.vue'
import Booking from './components/pages/Booking.vue'
import AddUser from './components/pages/AddUser.vue'
import EditUser from './components/pages/EditUser.vue'
import Profile from './components/pages/Profile.vue'
import ChangePass from './components/pages/ChangePass.vue'
import AddBooking from './components/pages/Booking/AddBooking.vue'
import EditBooking from './components/pages/Booking/EditBooking.vue'
import Smartbox from './components/pages/Smartbox/Index.vue'
import AddSmartbox from './components/pages/Smartbox/AddDevice.vue'
import EditSmartbox from './components/pages/Smartbox/EditDevice.vue'
import ForgotPassword from './components/pages/UpdateForgotPassword.vue'
import CountryList from './components/pages/Country/Index.vue'
import CountryAdd from './components/pages/Country/Add.vue'
import CountryEdit from './components/pages/Country/Edit.vue'
import StateList from './components/pages/State/Index.vue'
import StateAdd from './components/pages/State/Add.vue'
import StateEdit from './components/pages/State/Edit.vue'
import CityList from './components/pages/City/Index.vue'
import CityAdd from './components/pages/City/Add.vue'
import CityEdit from './components/pages/City/Edit.vue'
import PagesList from './components/pages/Pages/Index.vue'
import PagesAdd from './components/pages/Pages/Add.vue'
import PagesEdit from './components/pages/Pages/Edit.vue'
import PageTypeList from './components/pages/PageType/Index.vue'
import PageTypeAdd from './components/pages/PageType/Add.vue'
import PageTypeEdit from './components/pages/PageType/Edit.vue'
Smartbox




Vue.use(Router)

export default new Router({
    mode:'history',
    base: '/',
    routes:[
        {   
            path:'/',
            component:Login
        },
        {
            name: 'dashboard',
            path:'/dashboard',
            component:Dashboard
        },
        {
            name: 'forgot',
            path:'/forgot',
            component:Forgot
        },
        {
            name: 'USERS', 
            path:'/users',
            component:Users
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
            path:'/country',component:CountryList
        },
        {
            path:'/add-country',component:CountryAdd
        },

        {
            name: 'country-edit',
            path: '/country-edit/:id',
            component: CountryEdit,
            props: true
        },
        {
            name: 'edit',
            path: '/edit/:id',
            component: EditUser,
            props: true
        },
        {
            name: 'profile',
            path: '/profile',
            component: Profile
        },
        {
            name: 'pass',
            path: '/change_pass/:id',
            component: ChangePass
        },
        {
            name: 'changepass',
            path: '/change_pass',
            component: ChangePass
        },
        {
            name: 'bookingedit',
            path: '/booking-edit/:id',
            component: EditBooking
        },
        {
            name: 'device-edit',
            path: '/smartbox-edit/:id',
            component: EditSmartbox
        },
        
        {
            path: '/smartbox-list',
            component: Smartbox
        },
        {
            path:'/add-smartbox',component:AddSmartbox
        },
        
        {
            name: 'update-password',
            path: '/update-password/:token',
            component: ForgotPassword
        },
        {
            path:'/state',
            component:StateList
        },
        {
            path:'/add-state',
            component:StateAdd
        },

        {
            name: 'state-edit',
            path: '/state-edit/:id',
            component: StateEdit,
            props: true
        },
        
        {
            path:'/city',
            component:CityList
        },
        {
            path:'/add-city',
            component:CityAdd
        },

        {
            name: 'city-edit',
            path: '/city-edit/:id',
            component: CityEdit,
            props: true
        },

        {
            path:'/page-type',
            component:PageTypeList
        },
        {
            path:'/add-page-type',
            component:PageTypeAdd
        },

        {
            name: 'page-type-edit',
            path: '/page-type-edit/:id',
            component: PageTypeEdit,
            props: true
        },

        {
            path:'/pages',
            component:PagesList
        },
        {
            path:'/add-page',
            component:PagesAdd
        },

        {
            name: 'page-edit',
            path: '/page-edit/:id',
            component: PagesEdit,
            props: true
        },
        
        
        
    ]
})

