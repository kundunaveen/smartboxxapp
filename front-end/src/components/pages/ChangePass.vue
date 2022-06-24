<template>
  <div id="wrapper">
    <div class="preloader" v-if="loading">
      <div class="cssload-speeding-wheel"></div>
    </div>
    <Nav />
    <div class="page-wrapper">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading">
                Change Password
                <router-link
                  type="reset"
                  to="/dashboard"
                  class="btn btn-default cancel-bttnn back-new-bttn"
                >
                  <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                </router-link>
              </div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit.prevent="updatePassword">
                    <div class="form-body">
                      <!-- <h3 class="box-title">Change Password</h3> -->
                      <p v-if="error" class="text-danger">{{ error }}</p>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Password</label>
                            <input
                              type="password"
                              class="form-control"
                              placeholder="Enter Password"
                              v-model="password"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Confirm Password</label>
                            <input
                              type="password"
                              class="form-control"
                              placeholder="Confirm Password"
                              v-model="password_confirmation"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                      </div>

                      <hr />
                    </div>
                    <div class="form-actions">
                      <button
                        type="submit"
                        class="btn btn-success"
                        style="margin-right: 8px"
                      >
                        <i class="fa fa-check"></i> Update
                      </button>
                      <router-link
                        type="reset"
                        to="/users"
                        class="btn btn-default"
                      >
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Cancel
                      </router-link>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Nav from "./../layout/Nav.vue";
import axios from "axios";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "ChangePass",
  data() {
    return {
      password: "",
      password_confirmation: "",
      error: null,
    };
  },

  methods: {
    updatePassword(e) {
      e.preventDefault();
      const input = {
        password: this.password,
        password_confirmation: this.password_confirmation,
      };

      console.log(
        "typeof `${this.$route.params.id}`",
        typeof `${this.$route.params.id}`
      );
      if (`${this.$route.params.id}` !== "undefined") {
        urll = `/api/change_pass/${this.$route.params.id}`;
        axios.put(urll, input).then((res) => {
          if (res.data.status == "error" || res.data.Status == false) {
            this.$toaster.error(res.data.message);
            this.error = res.data.message;
          } else {
            this.$toaster.success("Password update successfully.");
            this.error = null;
            this.$router.push("/users");
          }
        });
      } else {
        var urll = `/api/change_pass`;
        axios.post(urll, input).then((res) => {
          if (res.data.status == "error" || res.data.Status == false) {
            this.$toaster.error(res.data.message);
            this.error = res.data.message;
          } else {
            this.$toaster.success("Password update successfully.");
            this.error = null;
            this.$router.push("/change_pass");
          }
        });
      }
    },
  },
  components: {
    Nav,
  },
};
</script>

<style>
</style>