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
                Edit City
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
                  <form action="#" @submit.prevent="updatestate">
                    <div class="form-body">
                      <!-- h3 class="box-title">Edit City</h3-->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!-- hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Country</label>
                            <Select2
                              v-model="country.country_id"
                              :options="countries"
                              :settings="{ width: '100%' }"
                              @change="onChange($event)"
                              required=""
                            >
                            </Select2>
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>State</label>
                            <Select2
                              v-model="country.state_id"
                              :options="states"
                              :settings="{ width: '100%' }"
                              required=""
                            >
                            </Select2>
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
import Select2 from "v-select2-component";
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
      states: [],
      countries: [],
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

      axios.get(`/api/get_state/${event}`).then((res) => {
        console.log("tttttt", res.data.data);
        this.states = res.data.data;
        this.loading = false;
        // this.$toaster.success("Status has been change! successfully.");
      });
    },
  },
  components: {
    Nav,
    Select2,
  },
  async created() {
    this.loading = true;
    const response1 = await axios.get("/api/country_without_code");
    this.countries = response1.data.data;
    
    const response = await axios.get(`/api/city/${this.$route.params.id}`);
    this.country = response.data.data;
    this.onChange(response.data.data.country_id);
    this.loading = false;
  },
};
</script>
<style>
</style>
