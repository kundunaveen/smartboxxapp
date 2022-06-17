<template>
  <div id="wrapper">
    <Nav />
    <div class="page-wrapper">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading">Add User</div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit="handleSubmit">
                    <div class="form-body">
                      <h3 class="box-title">Add User</h3>
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <hr />
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Name</label>
                            <input
                              class="form-control"
                              placeholder="Ex:Jackson"
                              v-model="name"
                              required=""
                              autocomplete="on|off"
                            />
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Email</label>
                            <input
                              type="email"
                              class="form-control"
                              placeholder="Ex: Jackson@temporary-mail.net"
                              v-model="email"
                              required=""
                              autocomplete="on|off"
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
                            <label class="control-label">Mobile</label>
                            
                            <div class="row">
                              <div class="col-lg-6">
                                <select
                                  name="code"
                                  class="form-select form-control select2"
                                  v-model="code"
                                  required=""
                                  autocomplete="on|off"
                                >
                                  <option value="" v-if="iteams">
                                    --select Country--
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
                                  v-model="phone"
                                  required=""
                                  autocomplete="on|off"
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
                              v-model="address"
                              required=""
                              autocomplete="on|off"
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
                              v-model="city"
                              required=""
                              autocomplete="on|off"
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
                              v-model="state"
                              required=""
                              autocomplete="on|off"
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
                              v-model="country"
                              required=""
                              autocomplete="on|off"
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
                              v-model="zip"
                              required=""
                              autocomplete="on|off"
                            />
                          </div>
                        </div>
                        <!--/span-->
                      </div>

                      <!--/row-->

                      <hr />
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-success " style="margin-right:8px">
                        <i class="fa fa-check"></i> Save
                      </button>
                      <router-link
                        type="reset"
                        to="/users"
                        class="btn btn-default "
                      >
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
  name: "AddUser",
  data() {
    return {
      name: "",
      email: "",
      password: "",
      phone: "",
      address: "",
      error: null,
      iteams: countries,
      code: "",
      city: "",
      state: "",
      country: "",
      zip: "",
    };
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        name: this.name,
        email: this.email,
        address: this.address,
        phone: this.phone,
        code: this.code,
        city: this.city,
        state: this.state,
        country: this.country,
        zip: this.zip,
      };
      console.log("input", input);
      axios
        .post("/api/add_user", input)
        .then((res) => {
          if (res.data.success == true) {
            this.$toaster.success("User add successfully.");
            this.error = null;
            this.$router.push("/users");
          } else {
            this.error = res.data.message;
            this.$toaster.error(res.data.message);
          }
        })
        .catch((err) => {
          // console.log(err.errors);
          this.$toaster.error(err.errors);
          this.error = "Record not save please check";
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