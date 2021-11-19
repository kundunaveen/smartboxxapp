<template>
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form @submit="handleSubmit">
            <h1>Forgot Password</h1>
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
              <button class="btn btn-default submit" type="submit">
                Submit
              </button>
              <router-link class="reset_pass" to="/">Login</router-link>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
            

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
  name: "Forgot",
  data() {
    return {
      email: ""
    };
  },
  methods: {
   async handleSubmit(e) {
      e.preventDefault();

      const input = {
        email: this.email
      };

      const response = await axios.post('/api/login',input);
   
      localStorage.setItem('token',response.data.data.token);
    //  const response = await axios.post('http://127.0.0.1:8000/api/login',input).then((response) => {
    //     console.log(response);
    //   });
     
    },
  },
};
</script>

<style>

</style>