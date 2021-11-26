<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Add Booking</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">Add New Booking<router-link
                        type="reset"
                        
                        to="/booking"
                      >
                        Back
                      </router-link></div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    
                         <p v-if="error" class="text-danger "> {{error}}</p>
                    <form role="form" @submit="handleSubmit">
                      <div class="form-group">
                        <label>Device Type</label>

                        <select
                          name="device_id"
                          class="form-select form-control"
                          v-model="device_id"
                          required=""
                        >
                          <option
                            v-bind:value="device.id"
                            v-for="device in devices"
                            :key="device.id"
                          >
                            {{ device.name }}
                          </option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Select days</label>
                        <div class="radio">
                          <label>
                            <input
                              type="radio"
                              name="optionsRadios"
                              id="optionsRadios1"
                              value="0"
                              checked=""
                              v-model="slot_type"
                            />Single Day
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input
                              type="radio"
                              name="optionsRadios"
                              id="optionsRadios2"
                              value="1"
                              
                              v-model="slot_type"
                            />Multiple Day
                          </label>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6" v-show="slot_type === '0'">
                            <label>single Day</label>
                            <date-picker
                              v-model="time1"
                              valueType="format"
                            ></date-picker>
                          </div>
                          <div class="col-lg-6" v-show="slot_type === '1'">
                            <label>Multiple Day</label>
                            <date-picker
                          
                              v-model="time3"
                              ng-model-options="{timezone: 'utc'}"
                              range
                              style="width: 100%"
                            ></date-picker>
                          </div>
                        </div>
                      </div>

                      <!-- <div class="form-group" v-show="x === '0'">
                        <label>Slot</label>
                        <input
                          type="email"
                          class="form-control"
                          placeholder="Enter Email"
                          required=""
                        />
                      </div> -->
                      <div class="form-group">
                        <label>Mobile</label>
                        <input
                          type="number"
                          class="form-control"
                          placeholder="Enter Mobile"
                          required=""
                          v-model="mobile"
                        />
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          required=""
                          v-model="address"
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
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
  name: "AddBooking",
  data() {
    return {
      slot_type: "0",
      devices: "",
      device_id:"",
      mobile:"",
      address:"",
      time1: "",
      time3: "",
      error: null,
    };
  },
  components: {
    Nav,
    DatePicker,
  },
  async created() {
    const response = await axios.get("/api/get_device");
    console.log("response.data.data", response.data);
    this.devices = response.data.data;
  },
   methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        device_id:this.device_id,
        slot_type: this.slot_type,
        start_date: this.time1,
        range_date: this.time3,
        address: this.address,
        mobile:this.mobile
      };
  console.log('input',input);
      axios
        .post("/api/add_booking", input)
        .then((res) => {
          if(res.data.status=='success'){
               this.error = null;
          this.$router.push("/booking");
          }else{
            this.error = res.data.custom;
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
<style>
</style>
