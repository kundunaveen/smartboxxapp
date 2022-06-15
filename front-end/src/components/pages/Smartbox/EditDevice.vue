<template>
  <div id="wrapper">
    <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Edit Smartbox</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/smartbox-list">
                  Back
                </router-link>
                Edit Smartbox
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit.prevent="updateDevice">
                      <div class="form-group">
                        <label>Name</label>
                        <input
                          class="form-control"
                          placeholder="Ex:Jackson"
                          v-model="device.name"
                          required=""
                          autocomplete="on|off"
                        />
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6">
                            <label>Latitude</label
                            ><input
                              type="text"
                              placeholder="Example: 40.785091"
                              required="required"
                              autocomplete="on|off"
                              class="form-control"
                              v-model="device.lat"
                            />
                          </div>
                          <div class="col-lg-6">
                            <label>Longitude</label
                            ><input
                              type="text"
                              placeholder="Example: -73.968285"
                              required="required"
                              autocomplete="on|off"
                              class="form-control"
                              v-model="device.long"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6">
                            <label>Image</label>
                            <input
                              type="file"
                              class="form-control"
                              multiple
                              accept="image/jpeg"
                              @change="uploadImage"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Address</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          v-model="device.address"
                          required=""
                        ></textarea>
                      </div>
                      <div class="form-group">
                        <label>Description</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          v-model="device.description"
                          required=""
                        ></textarea>
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
  name: "EditDevice",
  data() {
    return {
      device: {},
      file: "",
      error: "",
      loading: "",
      files: [],
    };
  },
  methods: {
    updateDevice() {
      this.loading = true;
      let input = new FormData();

      for (let i = 0; i < this.files.length; i++) {
        input.append("image[]", this.files[i]);
      }

      input.append("name", this.device.name);
      input.append("description", this.device.description);
      input.append("lat", this.device.lat);
      input.append("long", this.device.long);
      input.append("address", this.device.address);
      input.append("id", `${this.$route.params.id}`);
      axios({
        method: "post",
        url: `/api/update_device`,
        data: input,
      })
        // .put(`/api/update_device/${this.$route.params.id}`, this.device)
        .then((res) => {
          this.loading = false;
          if (res.data.success == true) {
            this.error = null;
            this.$toaster.success("Record update successfully.");
            this.$router.push("/smartbox-list");
          } else {
            this.$toaster.error(res.data.custom);
            this.error = res.data.custom;
          }
        });
    },
    uploadImage(e) {
      const selectedFiles = e.target.files;

      for (let i = 0; i < selectedFiles.length; i++) {
        // let img = {
        //   src: URL.createObjectURL(selectedFiles[i]),
        //   file: selectedFiles[i],
        // };
        // this.images.push(img);
        this.files.push(selectedFiles[i]);
      }
    },
  },
  components: {
    Nav,
  },
  async created() {
    this.loading = true;
    const response = await axios.get(
      `/api/view_device/${this.$route.params.id}`
    );
    this.device = response.data.data;
    this.loading = false;
  },
};
</script>
<style>
</style>
