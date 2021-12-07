<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Create Password</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                Create Password<router-link type="reset" to="/users">
                  Back
                </router-link>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit.prevent="updatePassword">
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

                      <button type="submit" class="btn btn-default">
                        Save
                      </button>
                    </form>
                  </div>
                  <!-- /.col-lg-6 (nested) -->

                  <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
              </div>
              <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
          </div>
          <!-- /.col-lg-12 -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Nav from "./../layout/Nav.vue";
import axios from "axios";
import Vue from 'vue' 
import Toaster from 'v-toaster' 
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 5000})

export default {
  name: "ChangePass",
  data() {
    return {
   
      password: "",
      password_confirmation:"",
      error: null,
    };
  },

  methods: {
    updatePassword(e) {
  e.preventDefault();
        const input = {
        password:this.password,
        password_confirmation: this.password_confirmation
      };
      axios
        .put(`/api/change_pass/${this.$route.params.id}`, input)
        .then((res) => {
          console.log("users", res.data.status);
          if (res.data.status == "error"){
                 this.$toaster.error(res.data.message)
            this.error = res.data.message;
          } else {
            this.$toaster.success('Password update successfully.')
            this.error = null;
            this.$router.push("/users");
          }
        });
    },
  },
  components: {
    Nav,
  },
};
</script>

<style>
</style>