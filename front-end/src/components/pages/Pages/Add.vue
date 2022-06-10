<template>
  <div id="wrapper">
    <div v-if="loading" class="loader"></div>

    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Add Page</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/page"> Back </router-link>
                Add New Page
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit="handleSubmit">
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
                      <div class="form-group">
                        <label>Details</label>
                        
                                <ckeditor v-model="detail"></ckeditor>

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
import CKEditor from 'ckeditor4-vue';

Vue.use(CKEditor,Toaster, { timeout: 5000 });

export default {
  name: "AddDevice",
  data() {
    return {
      detail: "",
      title: "",
      loading: false,
      error: "",
      pagetype: "",
      editorConfig:""
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
