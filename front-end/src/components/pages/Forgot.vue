<template>
  <section id="wrapper" class="login-register">
    <div class="preloader" v-if="loading">
      <div class="cssload-speeding-wheel"></div>
    </div>
    <div class="login-box">
      <div class="white-box">
        <form class="form-horizontal" id="" @submit="handleSubmit">
          <div class="form-group">
            <div class="col-xs-12">
              <h3>Recover Password</h3>
              <p v-if="error" class="text-danger">{{ error }}</p>
              <p v-if="success" class="text-success">{{ success }}</p>
              <p class="text-muted">
                Enter your Email and instructions will be sent to you!
              </p>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input
                type="email"
                class="form-control"
                placeholder="Email"
                v-model="email"
                required=""
              />
            </div>
          </div>
          <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
              <button
                class="
                  btn btn-primary btn-lg btn-block
                  text-uppercase
                  waves-effect waves-light reset-password-bttn
                "
                type="submit"
              >
                Reset
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>
<script>
import axios from "axios";

export default {
  name: "Forgot",
  data() {
    return {
      email: "",
      error: null,
      success: null,
      save_button: "Submit",
      loading: false,
    };
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();
      this.loading = true;
      const input = {
        email: this.email,
      };
      this.save_button = "Wait..";

      await axios
        .post("/api/send_link", input)
        .then((resp) => {
          if (resp.data.status == "error") {
            let current_error = resp.data.message.email;
            this.error = current_error;
            this.success = null;
          } else {
            this.success = resp.data.message;
            this.error = null;
          }

          this.save_button = "Submit";
        })
        .catch((err) => {
          console.log(err);
          this.save_button = "Submit";
          this.error = "Somthing went wrong";
        });
      this.loading = false;
    },
  },
};
</script>
