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
              <div class="panel-heading">Edit City</div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit.prevent="updatestate">
                    <div class="form-body">
                      <h3 class="box-title">Edit City</h3>
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <hr />
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Country</label>
                            <select
                              name="country_id"
                              class="form-select form-control"
                              v-model="country.country_id"
                              required=""
                              @change="onChange($event)"
                            >
                              <option value="" v-if="countries">
                                -- Select country --
                              </option>
                              <option
                                v-bind:value="country.id"
                                v-for="country in countries"
                                :key="country.id"
                              >
                                {{ country.name }}
                              </option>
                            </select>
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>State</label>
                            <select
                              name="state_id"
                              class="form-select form-control"
                              v-model="country.state_id"
                              required=""
                            >
                              <option value="" v-if="states">
                                -- Select state --
                              </option>
                              <option value="" v-if="!states">
                                -- Please Select country --
                              </option>
                              <option
                                v-bind:value="state.id"
                                v-for="state in states"
                                :key="state.id"
                              >
                                {{ state.name }}
                              </option>
                            </select>
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
                              v-model="country.city"
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
                              v-model="country.region"
                              required=""
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
                        <i class="fa fa-check"></i> Update
                      </button>
                      <router-link
                        type="reset"
                        to="/city"
                        class="btn btn-default"
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
import Nav from "./../../layout/Nav.vue";

import "vue2-datepicker/index.css";
import axios from "axios";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";

Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "Editcountry",
  data() {
    return {
      country: {},
      loading: false,
      states: "",
      countries: "",
      error: "",
      state_id: "",
    };
  },
  methods: {
    updatestate() {
      axios
        .put(`/api/city/${this.$route.params.id}`, this.country)
        .then((res) => {
          if (res.data.success == true) {
            this.error = null;
            this.$toaster.success("Record update successfully.");
            this.$router.push("/city");
          } else {
            this.$toaster.error(res.data.custom);
            this.error = res.data.custom;
          }
        });
    },
    onChange(event) {
      this.loading = true;
      axios.get(`/api/get_state/${event.target.value}`).then((res) => {
        this.loading = false;
        this.states = res.data.data;
        // this.$toaster.success("Status has been change! successfully.");
      });
    },
  },
  components: {
    Nav,
  },
  async created() {
    this.loading = true;
    const response = await axios.get(`/api/city/${this.$route.params.id}`);
    this.country = response.data.data;

    const response1 = await axios.get("/api/country");
    this.countries = response1.data.data;

    const res = await axios.get(
      `/api/get_state/${response.data.data.country_id}`
    );
    this.states = res.data.data;
    this.state_id = response.data.data.state_id;
    this.loading = false;
  },
};
</script>
<style>
</style>
