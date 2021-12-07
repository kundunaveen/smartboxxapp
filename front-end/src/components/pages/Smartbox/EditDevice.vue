<template>
    <div id="wrapper">
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
                <router-link type="reset" to="/smartbox-list"> Back </router-link> Edit
               Smartbox
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
                        <label>Description</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          v-model="device.description"
                          required=""
                        ></textarea>
                      </div>


                      <button type="submit" class="btn btn-default">Update</button>
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
import Vue from 'vue' 
import Toaster from 'v-toaster' 
import 'v-toaster/dist/v-toaster.css'

Vue.use(Toaster, {timeout: 5000})

export default {
  name: "EditDevice",
  data() {
    return {
      device: {},

    };
  },
   methods: {
    updateDevice() {

      axios
        .put(
          `/api/update_device/${this.$route.params.id}`,
          this.device
        )
        .then((res) => {

           if(res.data.success==true){
               this.error = null;
                   this.$toaster.success('Record update successfully.')
          this.$router.push("/smartbox-list");
          }else{
                  this.$toaster.error(res.data.custom)
            this.error = res.data.custom;
          }
        });
    },
  },
  components: {
    Nav,
    
  },
  async created() {
    
    const response = await axios.get(
      `/api/view_device/${this.$route.params.id}`
    );
    this.device = response.data.data;
  
  },
};
</script>
<style>
</style>
