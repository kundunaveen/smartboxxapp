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
              <div class="panel-heading">Add SmartBoxx <router-link
                        type="reset"
                               to="/smartbox-list"
                        class="btn btn-default cancel-bttnn back-new-bttn"
                      >
                        <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                      </router-link></div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit="handleSubmit">
                    <div class="form-body">
                      <!-- h3 class="box-title">Add SmartBox</h3-->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!-- hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Name</label>
                            <input
                              class="form-control"
                              placeholder="Ex:Smartbox"
                              v-model="name"
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
                              v-model="lat"
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
                              v-model="long"
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
                              v-model="booking_cost"
                            />
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label class="m-r-5">Company name</label>
                             <select
                                  name="company"
                                  class="form-select form-control"
                                  v-model="company"
                                  required=""
                                  id="mobile_code"
                                >
                                    <option
                                    v-bind:value="cmp.id"
                                    v-for="cmp in companies"
                                    :key="cmp.id"
                                  >
                                    {{cmp.name}}
                                  </option>
                                </select>
                          </div>
                        </div>
                      </div>
                      <!--/row-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Address </label>
                            <textarea
                              class="form-control"
                              rows="3"
                              v-model="address"
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
                              v-model="description"
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
                        <i class="fa fa-check"></i> Save
                      </button>
                      <router-link
                        type="reset"
                        to="/smartbox-list"
                        class="btn btn-default cancel-bttnn"
                      >
                        <i aria-hidden="true" class="fa fa-times"></i> Cancel
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
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "AddDevice",
  data() {
    return {
      name: "",
      description: "",
      error: "",
      address: "",
      booking_cost: "",
      lat: "",
      long: "",
      image: {},
      imageUrl: "",
      files: [],
      rawData: [],
      // images: [],
      companies: [],
    };
  },

  components: {
    Nav,
  }, 
  async created() {
    this.loading = true;
    const responsee = await axios.get("/api/companies");
    this.companies = responsee.data.data;
    console.log(this.companies);
    this.loading = false;
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      let input = new FormData();

      for (let i = 0; i < this.files.length; i++) {
        input.append("image[]", this.files[i]);
      }
      input.append("booking_cost", this.booking_cost);
      input.append("name", this.name);
      input.append("description", this.description);
      input.append("lat", this.lat);
      input.append("long", this.long);
      input.append("address", this.address);
      input.append("company", this.company);

      axios({
        method: "post",
        url: "/api/add_device",
        data: input,
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        // axios
        // .post("/api/add_deviced", {files:this.files})
        .then((res) => {
          if (res.data.code == "200") {
            this.error = null;
            this.$toaster.success("Add record successfully.");
            this.$router.push("/smartbox-list");
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
};
</script>
