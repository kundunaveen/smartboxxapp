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
              <button class="btn btn-default submit" type="submit">
                {{save_button}}
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
      error: null,
      success: null,
      save_button : 'Submit'
    };
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        email: this.email,
      };
      this.save_button = 'Wait..'

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

           this.save_button = 'Submit'
        }).catch((err) => {
       console.log(err);
          this.save_button = 'Submit'
          this.error = "Somthing went wrong";
        });
    },
  },
};
</script>
