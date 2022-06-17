<template id="wrapper" class="login-register">
  <section id="wrapper" class="login-register">
    <div class="preloader" v-if="loading">
      <div class="cssload-speeding-wheel"></div>
    </div>
    <div class="login-box">
      <div class="white-box">
        <form @submit="handleSubmit" class="form-horizontal form-material">
          <h3 class="box-title m-b-20">Sign In</h3>
          <p v-if="error" class="text-danger">{{ error }}</p>
          <div
            class="
              myadmin-alert myadmin-alert-icon myadmin-alert-click
              alert-success
              myadmin-alert-top
              alerttop
            "
          >
            <i class="ti-user"></i> This is an example top alert. You can edit
            what u wish. <a href="#" class="closed">&times;</a>
          </div>

          <div class="form-group">
            <div class="col-xs-12">
              <input
                type="text"
                class="form-control"
                placeholder="Username"
                v-model="email"
                required=""
              />
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="password"
                required=""
              />
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <div class="checkbox checkbox-primary pull-left p-t-0">
                <input id="checkbox-signup" type="checkbox" />
                <label for="checkbox-signup"> Remember me </label>
              </div>
              <router-link class="text-dark pull-right" to="/forgot"
                >Lost your password?</router-link
              >
            </div>
          </div>
          <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
              <button
                class="
                  btn btn-info btn-lg btn-block
                  text-uppercase
                  waves-effect waves-light
                "
                type="submit"
              >
                Log In
              </button>
            </div>
          </div>

          <!-- <div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
            <p>
              Don't have an account?
              <a href="register.html" class="text-primary m-l-5"
                ><b>Sign Up</b></a
              >
            </p>
          </div>
        </div> -->
        </form>
      </div>
    </div>
  </section>
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
      loading: false,
    };
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();
      this.loading = true;
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
          this.$router.push({ name: "dashboard" });

          // location.href = "/dashboard"
        })
        .catch((err) => {
          console.log(err);
          // this.errors.push(error.response.data.errors)
          // $(".alerttop").fadeToggle(350);
          this.error = "Please check the credentials";
        });
      this.loading = false;
    },
  },
};
</script>

<style>
</style>