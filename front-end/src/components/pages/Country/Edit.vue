<template>
  <div id="wrapper">
        <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Edit Country</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/country">
                  Back
                </router-link>
                Edit Country
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit.prevent="updatecountry">
                      <div class="form-group">
                        <label>Name</label>
                        <input
                          class="form-control"
                          placeholder="Ex:Afghanistan"
                          v-model="country.name"
                          required=""
                          autocomplete="on|off"
                        />
                      </div>
                      <div class="form-group">
                        <label>Dial Code</label>
                        <input
                          class="form-control"
                          placeholder="Ex:+93"
                          v-model="country.dial_code"
                          required=""
                          autocomplete="on|off"
                        />
                      </div>
                      <div class="form-group">
                        <label>Code</label>
                        <input
                          class="form-control"
                          placeholder="Ex:AF"
                          v-model="country.code"
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
      loading:false
    };
  },
  methods: {
    updatecountry() {
      axios
        .put(`/api/country/${this.$route.params.id}`, this.country)
        .then((res) => {
          if (res.data.success == true) {
            this.error = null;
            this.$toaster.success("Record update successfully.");
            this.$router.push("/country");
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
    const response = await axios.get(`/api/country/${this.$route.params.id}`);
    this.country = response.data.data;
       this.loading = false;
  },
};
</script>
<style>
</style>
