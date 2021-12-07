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
                <router-link type="reset" to="/booking">
                  Back
                </router-link>Edit Booking
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                        <p v-if="error" class="text-danger "> {{error}}</p>
                    <form role="form" @submit.prevent="updateBooking">
                      <div class="form-group">
                        <label>Select smartbox</label>

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
                             <div class="col-lg-6" v-show="booking.slot_type === '0'">
                            <label>Select Time</label>
                            <div class="row">
                              <div class="col-lg-6">
                                <select
                                  name="start_slot"
                                  class="form-select form-control"
                                  v-model="editstart"
                                  required=""
                                >
                                  <option value="" >
                                    -- Start  Time--
                                  </option>

                                  <option
                                    v-bind:value="slot.time +''+ slot.standard "
                                    v-for="slot in startslots"
                                    :key="slot.time+''+ slot.standard"
                                  >
                                    {{ slot.time }}  {{ slot.standard }}
                                  </option>
                                </select>
                              </div>
                              <div class="col-lg-6">
                                <select
                                  name="end_slot"
                                  class="form-select form-control"
                                  v-model="editend"
                                  required=""
                                >
                                  <option value="" >
                                    -- End TIme--
                                  </option>
                                    <option
                                    v-bind:value="slot.time+''+ slot.standard"
                                    v-for="slot in endslots"
                                    :key="slot.time+''+ slot.standard"
                                  >
                                    {{ slot.time }}  {{ slot.standard }}
                                  </option>
                                </select>
                              </div>
                            </div>
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

                        <div class="row">
                          <div class="col-lg-6">
                            <select
                          name="code"
                          class="form-select form-control "
                          v-model="booking.code"
                          required=""
                        >
                        <option value="" v-if="iteams">--select country code--</option>
                          <option
                            v-bind:value="iteam.dial_code"
                            v-for="iteam in iteams"
                            :key="iteam.code"
                          >
                              {{ iteam.name }} {{ iteam.dial_code }}
                          </option>
                        </select>
                          </div>
                          <div class="col-lg-6">
                            <input
                              type="number"
                              class="form-control"
                              placeholder="EX: 7737719645"
                              v-model="booking.mobile"
                              required=""
                            />
                          </div>
                        </div>
                      </div>

                        <div class="form-group">
                        <label>Street</label>
                             <input type="text"
                          class="form-control "
                          placeholder="EX:877 Mulberry Lane"
                          v-model="booking.address"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>City</label>
                             <input type="text"
                          class="form-control "
                          placeholder="EX:877 Mulberry Lane"
                          v-model="booking.city"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>State</label>
                             <input type="text"
                          class="form-control "
                          placeholder="EX: Dehli"
                          v-model="booking.state"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>Country</label>
                              <select
                          name="code"
                          class="form-select form-control "
                          v-model="booking.country"
                          required=""
                        >
                        <option value="" v-if="iteams">--select Country--</option>
                          <option
                            v-bind:value="iteam.name"
                            v-for="iteam in iteams"
                            :key="iteam.code"
                          >
                              {{ iteam.name }} 
                          </option>
                        </select>
                      </div>
                       <div class="form-group">
                        <label>Zip</label>
                             <input type="text"
                          class="form-control "
                          placeholder="EX:India"
                          v-model="booking.zip"
                          required=""
                        />
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
import Vue from 'vue' 
import Toaster from 'v-toaster' 
import 'v-toaster/dist/v-toaster.css'
import countries from './../../../assets/countries'
import slot from "./../../../assets/slot";
Vue.use(Toaster, {timeout: 5000})

export default {
  name: "EditBooking",
  data() {
    return {
      booking: {},
      devices: "",
      range_date:this.endDate,
      endDate:"",
      error: null,
      iteams:countries,
      startslots:slot,
      endslots:slot,
      editstart:"",
      editend:""

     
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
                   this.$toaster.success('Record update successfully.')
          this.$router.push("/booking");
          }else{
                  this.$toaster.error(res.data.custom)
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
    this.editstart= response.data.data.start_time
    this.editend= response.data.data.end_time
   
  
    this.endDate = [new Date(response.data.data.start_date),new Date(response.data.data.end_date)]

    const res = await axios.get("/api/get_device");
    this.devices = res.data.data;
  
   
  },
};
</script>
<style>
</style>
