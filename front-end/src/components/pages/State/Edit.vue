<template>
  <div id="wrapper">
    <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Edit State</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/state"> Back </router-link>
                Edit State
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit.prevent="updatestate">
                      <div class="form-group">
                        <label>Country</label>
                        <select
                          name="country_id"
                          class="form-select form-control"
                          v-model="country.country_id"
                          required=""
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

                      <div class="form-group">
                        <label>Name</label>
                        <input
                          class="form-control"
                          placeholder="Ex:California"
                          v-model="country.name"
                          required=""
                          autocomplete="on|off"
                        />
                      </div>

                      <button type="submit" class="btn btn-default">
                        Update
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
    };
  },
  methods: {
    updatestate() {
      axios
        .put(`/api/state/${this.$route.params.id}`, this.country)
        .then((res) => {
          if (res.data.success == true) {
            this.error = null;
            this.$toaster.success("Record update successfully.");
            this.$router.push("/state");
          } else {
            this.$toaster.error(res.data.custom);
            this.error = res.data.custom;
          }
        });
    },
  },
  components: {
    Nav,
  },
  async created() {
    this.loading = true;
    const response = await axios.get(`/api/state/${this.$route.params.id}`);
    this.country = response.data.data;
    
    const response1 = await axios.get("/api/country");
    this.countries = response1.data.data;
    this.loading = false;
  },
};
</script>
<style>
</style>
