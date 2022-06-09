<template>
  <div id="wrapper">
        <div v-if="loading" class="loader"></div>

    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Add State</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/state"> Back </router-link>
                Add New State
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit="handleSubmit">
                      <div class="form-group">
                          <label>Country</label>
                        <select
                          name="country_id"
                          class="form-select form-control"
                          v-model="country_id"
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
                          v-model="name"
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
import Nav from "./../../layout/Nav.vue";

import axios from "axios";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "AddDevice",
  data() {
    return {
      name: "",
      country_id: "",
     loading:false,
      error: "",
      countries: "",
    };
  },

  components: {
    Nav,
  },
  async created() {
     this.loading = true;
    const response = await axios.get("/api/country");
     this.loading = false;

    this.countries = response.data.data;
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        name: this.name,
        country_id: this.country_id
      };

      axios
        .post("/api/state", input)
        .then((res) => {
          if (res.data.code == "200") {
            this.error = null;
            this.$toaster.success("Add record successfully.");
            this.$router.push("/state");
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
