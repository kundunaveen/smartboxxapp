<template>
  <div id="app">
   
    <Login v-if="!user"/>
     <router-view v-if="user"></router-view>
  </div>
</template>

<script>

import Login from './components/pages/Login.vue'
import axios from "axios";

export default {
  name: 'App',
  components:{
    Login
    
  },
    data() {
    return {
      user: null,
    };
  },
  async created() {
    const response = await axios.get("/api/get_details");
    this.user = response.data.data;
  },
}
</script>

<style>
.mr-md-auto, .mx-md-auto {
    margin-right: auto!important;
}
</style>
