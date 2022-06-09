<template>
  <div id="wrapper">
    <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Edit Page</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/pages"> Back </router-link>
                Edit Page
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit.prevent="updatestate">
                      <div class="form-group">
                        <label>Page Type</label>
                        <select
                          name="page_id"
                          class="form-select form-control"
                          v-model="page.page_type_id"
                          required=""
                        >
                          <option value="" v-if="pagetype">
                            -- Select page --
                          </option>
                          <option
                            v-bind:value="page.id"
                            v-for="page in pagetype"
                            :key="page.id"
                          >
                            {{ page.name }}
                          </option>
                        </select>
                      </div>
                      <div class="form-group">
                        <div class="form-group">
                          <label>Details</label>
                          <ckeditor v-model="page.detail"></ckeditor>
                        </div>
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
import CKEditor from "ckeditor4-vue";

Vue.use(CKEditor, Toaster, { timeout: 5000 });

export default {
  name: "Editpage",
  data() {
    return {
      page: {},
      loading: false,
    };
  },
  methods: {
    updatestate() {
      axios.put(`/api/page/${this.$route.params.id}`, this.page).then((res) => {
        if (res.data.success == true) {
          this.error = null;
          this.$toaster.success("Record update successfully.");
          this.$router.push("/pages");
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
    const response = await axios.get(`/api/page/${this.$route.params.id}`);
    this.page = response.data.data;

    const response1 = await axios.get("/api/page-type");
    this.pagetype = response1.data.data;
    this.loading = false;
  },
};
</script>
<style>
</style>
