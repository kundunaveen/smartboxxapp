<template>
  <div id="app">
    <Login v-if="!user" />
    <router-view v-if="user"></router-view>
  </div>
</template>

<script>
import Login from "./components/pages/Login.vue";
import axios from "axios";

export default {
  name: "App",
  components: {
    Login,
  },
  data() {
    return {
      user: null,
    };
  },
  async created() {
    
if (localStorage.getItem("token") !== null) {
await axios
      .get("/api/get_details")
      .then((response) => {
        this.user = response.data.data;
      })
      .catch((err) => {
         console.log("err", err);
      });
}
  

 
  },
};
</script>

<style>
.mr-md-auto,
.mx-md-auto {
  margin-right: auto !important;
}
</style>
