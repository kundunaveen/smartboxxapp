<template>
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form @submit="handleSubmit">
            <h1>Login</h1>
            <p v-if="error" class="text-danger">{{ error }}</p>
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
              <router-link class="reset_pass" to="/forgot" 
                >Lost your password?</router-link>
              
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
                <h1><i class="fa fa-paw"></i> smartboxapp</h1>
                <p>
                  ©2016 All Rights Reserved.smartboxapp.com. Privacy and Terms
                </p>
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
      error: null,
    };
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        email: this.email,
        password: this.password,
      };
  
 
        await axios
          .post("/api/login", input)
          .then((resp) => {
            localStorage.setItem("token", resp.data.data.token);
            this.error = null;
            
            // this.$router.push("/dashboard");
            // this.$router.push({ path: '/dashboard' })
            this.$router.push({ name: 'dashboard' })

            // location.href = "/dashboard"
          })
          .catch((err) => {
            console.log(err);
            // this.errors.push(error.response.data.errors)
            this.error = "Please check the credentials";
          });
  
    }
  },
};
</script>

<style>
</style>