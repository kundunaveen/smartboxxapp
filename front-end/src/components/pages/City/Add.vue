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
                Add City
                <router-link
                  type="reset"
                  to="/city"
                  class="btn btn-default cancel-bttnn back-new-bttn"
                >
                  <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                </router-link>
              </div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit="handleSubmit">
                    <div class="form-body">
                      <!-- h3 class="box-title">Add City</h3-->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!-- hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Country</label>
                            <Select2
                              v-model="country_id"
                              :options="countries"
                              :settings="{ width: '100%' }"
                              @select="onChange($event)"
                              required=""
                            />
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>State</label>
                            <Select2
                              v-model="state_id"
                              :options="states"
                              :settings="{ width: '100%' }"
                              @select="onChangeState($event)"
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
                            <label>City</label>
                            <input
                              class="form-control"
                              placeholder="Ex:California"
                              v-model="city"
                              required=""
                              autocomplete="on|off"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Region</label>
                            <input
                              class="form-control"
                              placeholder="Ex:xyz"
                              v-model="region"
                              autocomplete="on|off"
                            />
                          </div>
                        </div>
                        <!--/span-->

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
                        <i class="fa fa-check"></i> Save
                      </button>
                      <router-link
                        type="reset"
                        to="/city"
                        class="btn btn-default cancel-bttnn"
                      >
                        <i aria-hidden="true" class="fa fa-times"></i> Cancel
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
import $ from "jquery";
import Select2 from "vue3-select2-component";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "Add",
  data() {
    return {
      name: "",
      country_id: "",
      loading: false,
      error: "",
      countries: "",
      cities: "",
      city_id: "",
      city: "",
      region: "",
      states: "",
      state_id: "",
    };
  },

  components: {
    Nav,
    Select2,
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/country_without_code");
    this.loading = false;

    this.countries = response.data.data;
    setTimeout(() => {
      // $("#country").select2();
      $("#state").select2();
    });
  },
  methods: {
    onChange(event) {
      this.loading = true;
      axios.get(`/api/get_state/${event.id}`).then((res) => {
        this.loading = false;
        this.states = res.data.data;
        // this.$toaster.success("Status has been change! successfully.");
      });
      this.country_id = event.id;
    },
     onChangeState(event) {
     
      this.state_id = event.id;
    },
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        city: this.city,
        country_id: this.country_id,
        state_id: this.state_id,
        region: this.region,
      };

      axios
        .post("/api/city", input)
        .then((res) => {
          if (res.data.code == "200") {
            this.error = null;
            this.$toaster.success("Add record successfully.");
            this.$router.push("/city");
          } else {
            this.$toaster.error(res.data.message);
            this.error = res.data.message;
          }
        })
        .catch((err) => {
          console.log(err.errors);
          this.error = "Record not save please check";
        });
    },
  },
};
</script>
