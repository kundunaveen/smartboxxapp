<template>
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form @submit="handleSubmit">
            <h1>Forgot Password</h1>
            <p v-if="error" class="text-danger">{{ error }}</p>
            <p v-if="success" class="text-success">{{ success }}</p>
            <div>
              <input
                type="email"
                class="form-control"
                placeholder="Email"
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
              <input
                type="password"
                class="form-control"
                placeholder="Confirm new password"
                v-model="password_confirmation"
                required=""
              />
            </div>
            <div>
              <input
                type="hidden"
                class="form-control"
                placeholder="token"
                v-model="token"
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
      email: "",
      password: "",
      password_confirmation: "",

      error: null,
      success: null,
      token: `${this.$route.params.token}`,
    };
  },

  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        email: this.email,
        password: this.password,
        token: this.token,
        password_confirmation: this.password_confirmation,
      };

      await axios
        .post("/api/reset_password", input)
        .then((resp) => {
          console.log("send_link", resp.data.message.email);
          if (resp.data.status == "error") {
            let current_error = resp.data.message;
            this.error = current_error;
            this.success = null;
          } else {
            this.success = resp.data.message;
            this.error = null;
          }
          // localStorage.setItem("token", resp.data.data.token);

          // this.$router.push("/forgot");
        })
        .catch((err) => {
          console.log("err", err);
          // this.errors.push(error.response.data.errors)
          this.error = "Somthing went wrong";
        });
    },
  },
};
</script>

<style>
</style>