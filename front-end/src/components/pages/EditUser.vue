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
                Edit User
                <router-link
                  type="reset"
                  to="/users"
                  class="btn btn-default cancel-bttnn back-new-bttn"
                >
                  <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                </router-link>
              </div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit.prevent="updateUser">
                    <div class="form-body">
                      <!-- h3 class="box-title">Edit User</h3-->
                      <!-- <p v-if="error" class="text-danger">{{ error }}</p> -->
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
                                <Select2
                                  v-model="user.code"
                                  :options="code_with_countries"
                                  :settings="{ width: '100%' }"
                                />
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
                            <Select2
                              v-model="user.country"
                              :options="iteams"
                              :settings="{ width: '100%' }"
                            />
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
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>
                              <input
                                type="checkbox"
                                class="input-new-style"
                                v-bind:checked="user.status == '1'"
                                data-toggle="toggle"
                                data-size="xs"
                                @change="onChange"
                              />

                              Enable
                            </label>
                          </div>
                        </div>
                      </div>

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
                        to="/users"
                        class="btn btn-default"
                      >
                        <i class="fa fa-times" aria-hidden="true"></i> Cancel
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
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import Select2 from "v-select2-component";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "EditUser",
  data() {
    return {
      user: {},
      countries: [],
      code_with_countries: [],
    };
  },
  async created() {
    this.loading = true;
    const responsee = await axios.get("/api/country_with_code");
    this.code_with_countries = responsee.data.data;
    const responses = await axios.get("/api/country_without_code");
    this.iteams = responses.data.data;

    if (`${this.$route.params.id}` !== "undefined") {
      url1 = `/api/get_user/${this.$route.params.id}`;
    } else {
      var url1 = `/api/get_user`;
    }
 const response = await axios.get(url1);
    this.user = response.data.data;

    this.loading = false;
  },

  methods: {
    onChangeCode(val) {
      this.code = val.id;
    },
    updateUser() {
      console.log(" this.user", this.user);
      if (`${this.$route.params.id}` !== "undefined") {
        url = `/api/update_user/${this.$route.params.id}`;
        axios.put(url, this.user).then(() => {
          this.$toaster.success("Record update successfully.");
          this.$router.push("/users");
        });
      } else {
        var url = `/api/update_user`;
        axios.post(url, this.user).then(() => {
          this.$toaster.success("Record update successfully.");
          this.$router.push("/edit");
        });
      }
    },
    onChange(e) {
      this.user.status = e.target.checked == true ? 1 : 0;
    },
  },
  components: {
    Nav,
    Select2,
  },
};
</script>

<style>
</style>