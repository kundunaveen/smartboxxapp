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
              <div class="panel-heading">Add Page</div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit="handleSubmit">
                    <div class="form-body">
                      <h3 class="box-title">Add Page</h3>
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <hr />
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name</label>
                            <input
                              class="form-control"
                              placeholder="Ex:about-us"
                              v-model="title"
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

                            <ckeditor v-model="detail"></ckeditor>
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
                        <i class="fa fa-check"></i> Save
                      </button>
                      <router-link
                        type="reset"
                        to="/pages"
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

import axios from "axios";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import CKEditor from "ckeditor4-vue";

Vue.use(CKEditor, Toaster, { timeout: 5000 });

export default {
  name: "AddDevice",
  data() {
    return {
      detail: "",
      title: "",
      loading: false,
      error: "",
      pagetype: "",
      editorConfig: "",
    };
  },

  components: {
    Nav,
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/page-type");
    this.loading = false;

    this.pagetype = response.data.data;
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        detail: this.detail,
        title: this.title,
      };

      axios
        .post("/api/page", input)
        .then((res) => {
          if (res.data.code == "200") {
            this.error = null;
            this.$toaster.success("Add record successfully.");
            this.$router.push("/pages");
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
