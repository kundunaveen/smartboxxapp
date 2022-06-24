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
              <div class="panel-heading">Edit SmartBox <router-link
                        type="reset"
                        to="/users"
                        class="btn btn-default cancel-bttnn back-new-bttn"
                      >
                        <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                      </router-link></div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form role="form" @submit.prevent="updateDevice">
                    <div class="form-body">
                      <!-- h3 class="box-title">Edit SmartBox</h3 -->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!-- hr / -->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Name</label>
                            <input
                              class="form-control"
                              placeholder="Ex:Jackson"
                              v-model="device.name"
                              required=""
                              autocomplete="on|off"
                            />
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
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
                        </div>
                        <!--/span-->
                      </div>
                      <!--/row-->
                      <!--/row-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
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
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
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
                        <!--/span-->
                      </div>
                      <!--/row-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="m-r-5">Booking Cost</label
                            ><span class="tooltips">
                              <i
                                class="fa fa-info-circle"
                                aria-hidden="true"
                              ></i>
                              <span class="tooltiptext"> Per Hour </span> </span
                            ><input
                              type="number"
                              min="1"
                              placeholder="Example: 5"
                              required="required"
                              autocomplete="on|off"
                              class="form-control"
                              v-model="device.booking_cost"
                            />
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group"></div>
                        </div>
                        <!--/span-->
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Address</label>
                            <textarea
                              class="form-control"
                              rows="3"
                              v-model="device.address"
                              required=""
                            ></textarea>
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Description</label>
                            <textarea
                              class="form-control"
                              rows="3"
                              v-model="device.description"
                              required=""
                            ></textarea>
                          </div>
                        </div>
                        <!--/span-->
                      </div>

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
                        to="/smartbox-list"
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
      input.append("booking_cost", this.device.booking_cost);
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
