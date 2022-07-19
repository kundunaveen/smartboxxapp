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
                Add Company
                <router-link
                  type="reset"
                  to="/companies"
                  class="btn btn-default cancel-bttnn back-new-bttn"
                >
                  <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                </router-link>
              </div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit="handleSubmit">
                    <div class="form-body">
                      <!-- h3 class="box-title">Add User</h3-->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!--hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Company Name</label>
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
                                <Select2
                                  v-model="code"
                                  :options="code_with_countries"
                                  :settings="{ width: '100%' }"
                                  @select="onChange($event)"
                                />
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
                            <label class="control-label">Password</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder=""
                              v-model="password"
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
                            <label>Contact Person 1</label>

                            <input
                              type="text"
                              class="form-control"
                              v-model="contact_person1"
                              required=""
                              autocomplete="on|off"
                            />
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Contact Person 2</label>
                            <input
                              type="text"
                              class="form-control"
                              v-model="contact_person2"
                              required=""
                              autocomplete="on|off"
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
                        <i class="fa fa-check"></i> Save
                      </button>
                      <router-link
                        type="reset"
                        to="/companies"
                        class="btn btn-default cancel-bttnn"
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
import Nav from "./../../layout/Nav.vue";
import axios from "axios";

import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import Select2 from "vue3-select2-component";

Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "AddUser",
  data() {
    return {
      name: "",
      email: "",
      password: "",
      phone: "",
      error: null,
      iteams: [],
      code_with_countries: [],
      code: "",
      loading: false,
    };
  },

  async created() {
    this.loading = true;

    const response = await axios.get("/api/country_with_code");
    this.code_with_countries = response.data.data;
    const responses = await axios.get("/api/country_without_code");
    this.iteams = responses.data.data;
    // var country = responses.data.data;
    fetch("https://api.ipify.org?format=json")
      .then((x) => x.json())
      .then(({ ip }) => {
        axios.get(`/api/get-address-from-ip/${ip}`).then((result) => {
          this.state = result.data.data.regionName;
          this.city = result.data.data.cityName;
          this.zip = result.data.data.zipCode;
          // for (let x in country) {
          //   if (country[x].text == result.data.data.countryName) {
          //     var id = responses[x].id;
              
          //     var text = responses[x].text;
          //     this.country = { id, text };
             
          //   }
          // }
          // this.country = result.data.data.countryName;
        });

        //  this.state = location.data.regionName
      });

    this.loading = false;
  },
  methods: {
    mySelectEvent({ id, text }) {
      console.log({ id, text });
    },
    onChange(val) {
      this.code = val.id;
    },
    onChangeCountry(val) {
      this.country = val.id;
    },
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        name: this.name,
        email: this.email,
        password:this.password,
        address: this.address,
        phone: this.phone,
        code: this.code,
        contact_person1: this.contact_person1,
        contact_person2: this.contact_person2,
      };
      console.log("input", input);
      axios
        .post("/api/add-company", input)
        .then((res) => {
          if (res.data.success == true) {
            this.$toaster.success("User add successfully.");
            this.error = null;
            this.$router.push("/companies");
          } else {
            this.error = res.data.message;
            this.$toaster.error(res.data.message);
          }
        })
        .catch((err) => {
          this.$toaster.error(err.errors);
          this.error = "Record not save please check";
        });
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