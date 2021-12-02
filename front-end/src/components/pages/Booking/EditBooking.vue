<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Edit Booking</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                Edit Booking<router-link type="reset" to="/booking">
                  Back
                </router-link>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                        <p v-if="error" class="text-danger "> {{error}}</p>
                    <form role="form" @submit.prevent="updateBooking">
                      <div class="form-group">
                        <label>Device Type</label>

                        <select
                          name="device_id"
                          class="form-select form-control"
                          v-model="booking.device_id"
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
                              v-model="booking.slot_type"
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
                              v-model="booking.slot_type"
                            />Multiple Day
                          </label>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div
                            class="col-lg-6"
                            v-show="booking.slot_type === '0'"
                          >
                            <label>single Day</label>
                            <date-picker
                              v-model="booking.start_date"
                              valueType="format"
                            ></date-picker>
                          </div>
                          <div
                            class="col-lg-6"
                            v-show="booking.slot_type === '1'"
                          >
                            <label>Multiple Day</label>
                           
                            <date-picker
                            range
                            v-model="endDate" >
                              range
                              style="width: 100%"
                            >
                           
                            </date-picker>
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
                          v-model="booking.mobile"
                        />
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          required=""
                          v-model="booking.address"
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
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import axios from "axios";

export default {
  name: "EditBooking",
  data() {
    return {
      booking: {},
      devices: "",
      range_date:this.endDate,
      endDate:"",
      error: null,

     
    };
  },
   methods: {
    updateBooking() {
      this.booking.range_date= this.endDate
      axios
        .put(
          `/api/update_booking/${this.$route.params.id}`,
          this.booking
        )
        .then((res) => {

           if(res.data.success==true){
               this.error = null;
          this.$router.push("/booking");
          }else{
            this.error = res.data.custom;
          }
        });
    },
  },
  components: {
    Nav,
    DatePicker,
    
  },
  async created() {
    
    const response = await axios.get(
      `/api/view_booking/${this.$route.params.id}`
    );
    this.booking = response.data.data;
  
    this.endDate = [new Date(response.data.data.start_date),new Date(response.data.data.end_date)]

    const res = await axios.get("/api/get_device");
    this.devices = res.data.data;
  
   
  },
};
</script>
<style>
</style>
