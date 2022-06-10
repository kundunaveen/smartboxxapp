<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Add Smartbox</h1>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/smartbox-list">
                  Back
                </router-link>
                Add New Smartbox
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
                          placeholder="Ex:Smartbox"
                          v-model="name"
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
                              v-model="lat"
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
                              v-model="long"
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
                              id="file"
                              ref="file"
                              v-on:change="handleFileUpload()"
                            />
                          
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Address</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          v-model="address"
                          required=""
                        ></textarea>
                      </div>

                      <div class="form-group">
                        <label>Description</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          v-model="description"
                          required=""
                        ></textarea>
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
      description: "",
      error: "",
      address: "",
      lat: "",
      long: "",
      image: {},
      imageUrl: "",
      file: "",
    };
  },

  components: {
    Nav,
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();
      let input = new FormData();
      input.append("image", this.file);
      input.append("name", this.name);
      input.append("description", this.description);
      input.append("lat", this.lat);
      input.append("long", this.long);
      input.append("address", this.address);

      // const input = {
      //   name: this.name,
      //   description: this.description,
      //   image: this.image,
      //   lat: this.lat,
      //   long: this.long,
      //   address: this.address,
      // };

      axios({
        method: "post",
        url: "/api/add_device",
        data: input,
      })
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
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
      console.log("      this.file ", this.file);
    },
  },
};
</script>
