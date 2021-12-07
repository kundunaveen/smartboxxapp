<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Add Users</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/users"> Back </router-link> Add
                New User
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit="handleSubmit">
                      <div class="form-group">
                        <label>Name</label>
                        <input
                          class="form-control"
                          placeholder="Ex:Jackson"
                          v-model="name"
                          required=""
                          autocomplete="on|off"
                        />
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input
                          type="email"
                          class="form-control"
                          placeholder="Ex: Jackson@temporary-mail.net"
                          v-model="email"
                          required=""
                          autocomplete="on|off"
                        />
                      </div>
                      <div class="form-group">
                        <label>Mobile</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <select
                              name="code"
                              class="form-select form-control"
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

                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6">
                            <label>Street</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder="EX:877 Mulberry Lane"
                              v-model="address"
                              required=""
                              autocomplete="on|off"
                            />
                          </div>
                          <div class="col-lg-6">
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
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6">
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
                          <div class="col-lg-6">
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
                      </div>

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

                      <button type="submit" class="btn btn-default">Add</button>
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