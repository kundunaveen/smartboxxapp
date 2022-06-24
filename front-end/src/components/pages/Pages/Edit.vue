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
              <div class="panel-heading">Edit Page  <router-link
                        type="reset"
                        to="/users"
                        class="btn btn-default cancel-bttnn back-new-bttn"
                      >
                        <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                      </router-link></div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit.prevent="updatestate">
                    <div class="form-body">
                      <!-- h3 class="box-title">Edit Page</h3-->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!-- hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name</label>
                            <input
                          class="form-control"
                          placeholder="Ex:about-us"
                          v-model="page.title"
                          required=""
                          autocomplete="on|off"
                        />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <!--/span-->
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Details</label>
                          <ckeditor v-model="page.detail"></ckeditor>
                          </div>
                        </div>
                        <!--/span-->
                      </div>
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
                        <i class="fa fa-check"></i> Update
                      </button>
                      <router-link
                        type="reset"
                        to="/pages"
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
