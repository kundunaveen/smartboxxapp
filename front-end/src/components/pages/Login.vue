<template>
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form @submit="handleSubmit">
            <h1>Login</h1>
            <div>
              <input
                type="text"
                class="form-control"
                placeholder="Username"
                v-model="email"
                required=""
              />
            </div>
            <div>
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="password"
                required=""
              />
            </div>
            <div>
              <button class="btn btn-default submit" type="submit">
                Log in
              </button>
              <router-link class="reset_pass" to="/forgot">Lost your password?</router-link>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <!-- <p class="change_link">
                New to site?
                <a href="#signup" class="to_register"> Create Account </a>
              </p> -->

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-paw"></i> Booking</h1>
                <p>©2016 All Rights Reserved.Booking.com. Privacy and Terms</p>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
   async handleSubmit(e) {
      e.preventDefault();

      const input = {
        email: this.email,
        password: this.password
      };

      const response = await axios.post('/api/login',input);
   
      localStorage.setItem('token',response.data.data.token);
      this.$router.push('/dashboard');
    //  const response = await axios.post('http://127.0.0.1:8000/api/login',input).then((response) => {
    //     console.log(response);
    //   });
     
    },
  },
};
</script>

<style>

</style>