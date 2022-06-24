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
              <div class="panel-heading">Edit User <router-link
                        type="reset"
                        to="/dashboard"
                        class="btn btn-default cancel-bttnn back-new-bttn"
                      >
                        <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                      </router-link></div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit.prevent="updateUser">
                    <div class="form-body">
                      <!-- h3 class="box-title">Edit User</h3-->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!-- hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name</label>
                            <input
                              class="form-control"
                              placeholder="Enter Name"
                              v-model="user.name"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Email</label>
                            <input
                              class="form-control"
                              placeholder="Enter Email"
                              v-model="user.email"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                      </div>
                      <!--/row-->
                      <!--/row-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Mobile</label>

                            <div class="row">
                              <div class="col-lg-6">
                                <select
                                  name="code"
                                  class="form-select form-control"
                                  v-model="user.code"
                                  required=""
                                >
                                  <option value="" v-if="iteams">
                                    Country
                                  </option>
                                  <option
                                    v-bind:value="iteam.dial_code"
                                    v-for="iteam in iteams"
                                    :key="iteam.code"
                                  >
                                    {{ iteam.name }} {{ iteam.dial_code }}
                                  </option>
                                </select>
                              </div>
                              <div class="col-lg-6">
                                <input
                                  type="number"
                                  class="form-control"
                                  placeholder="EX: 7737719645"
                                  v-model="user.phone"
                                  required=""
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Street</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder="EX:877 Mulberry Lane"
                              v-model="user.address"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                      </div>
                      <!--/row-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>City</label>

                            <input
                              type="text"
                              class="form-control"
                              placeholder="EX:877 Mulberry Lane"
                              v-model="user.city"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>State</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder="EX: Dehli"
                              v-model="user.state"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                      </div>

                      <!--/row-->
                      <!--/row-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Country</label>
                            <select
                              name="code"
                              class="form-select form-control"
                              v-model="user.country"
                              required=""
                            >
                              <option value="" v-if="iteams">
                                --select Country--
                              </option>
                              <option
                                v-bind:value="iteam.name"
                                v-for="iteam in iteams"
                                :key="iteam.code"
                              >
                                {{ iteam.name }}
                              </option>
                            </select>
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Zip</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder="EX:India"
                              v-model="user.zip"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                      </div>

                      <!--/row-->
                      <!--/row-->
                      

                      <!--/row-->
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
                        to="/dashboard"
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
        <!--row -->
        <!-- ===== Right-Sidebar ===== -->

        <!-- ===== Right-Sidebar-End ===== -->
      </div>
      <!-- /.container-fluid -->
      <!-- ===== footer ===== -->

      <!-- ===== footer-End ===== -->
    </div>
  </div>
</template>
<script>
import Nav from "./../layout/Nav.vue";
import axios from "axios";
import countries from "./../../assets/countries";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "EditUser",
  data() {
    return {
      user: {},
      iteams: countries,
    };
  },
  async created() {
    if (`${this.$route.params.id}` !== "undefined") {
      url1 = `/api/get_user/${this.$route.params.id}`;
    } else {
      var url1 = `/api/get_user`;
    }

    const response = await axios.get(url1);
    this.user = response.data.data;
  },
  methods: {
    updateUser() {
      if (`${this.$route.params.id}` !== "undefined") {
        url = `/api/update_user/${this.$route.params.id}`;
         axios.put(url, this.user).then(() => {
          this.$toaster.success("Record update successfully.");
          this.$router.push("/users");
        });
      } else {
        var url = `/api/update_user`;
         axios.post(url, this.user).then((res) => {
          console.log(res);
          this.$toaster.success("Record update successfully.");
          // this.$router.push("/dashboard");.
          // this.$router.push({ name: "dashboard" });
          this.$router.push("/").catch(()=>{});
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