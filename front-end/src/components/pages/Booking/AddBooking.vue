<template>
  <div id="wrapper">
        <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Add Booking</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/booking"> Back </router-link>Add
                New Booking
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <p v-if="error" class="text-danger">{{ error }}</p>
                    <form role="form" @submit="handleSubmit">
                      <div class="form-group">
                        <label>Select smartbox</label>

                        <select
                          name="device_id"
                          class="form-select form-control"
                          v-model="device_id"
                          required=""
                        >
                          <option value="" v-if="devices">
                            -- Select box --
                          </option>
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
                        <label>Select Users</label>

                        <select
                          name="device_id"
                          class="form-select form-control"
                          v-model="user_id"
                          required=""
                        >
                          <option value="" v-if="users">
                            -- Select User --
                          </option>
                          <option
                            v-bind:value="user.id"
                            v-for="user in users"
                            :key="user.id"
                          >
                            {{ user.name }}
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
                          <div class="col-lg-6" v-show="slot_type === '0'">
                            <label>Select Time</label>
                            <div class="row">
                              <div class="col-lg-6">
                                <select
                                  name="start_slot"
                                  class="form-select form-control"
                                  v-model="startSlot"
                                  required=""
                                >
                                  <option value="">-- Start Time--</option>

                                  <option
                                    v-bind:value="
                                      slot.time + '' + slot.standard
                                    "
                                    v-for="slot in startslots"
                                    :key="slot.time"
                                  >
                                    {{ slot.time }} {{ slot.standard }}
                                  </option>
                                </select>
                              </div>
                              <div class="col-lg-6">
                                <select
                                  name="end_slot"
                                  class="form-select form-control"
                                  v-model="endSlot"
                                  required=""
                                >
                                  <option value="">-- End TIme--</option>
                                  <option
                                    v-bind:value="
                                      slot.time + '' + slot.standard
                                    "
                                    v-for="slot in endslots"
                                    :key="slot.time"
                                  >
                                    {{ slot.time }} {{ slot.standard }}
                                  </option>
                                </select>
                              </div>
                            </div>
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

                      <!-- <div class="form-group">
                        <label>Mobile</label>
                        <div class="row">
                          <div class="col-lg-6">
                            <select
                              name="code"
                              class="form-select form-control"
                              v-model="code"
                              required=""
                            >
                              <option value="" v-if="iteams">
                                --select country code--
                              </option>
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
                              v-model="mobile"
                              required=""
                            />
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Street</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="EX:877 Mulberry Lane"
                          v-model="address"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>City</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="EX:877 Mulberry Lane"
                          v-model="city"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>State</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="EX: Dehli"
                          v-model="state"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>Country</label>
                        <select
                          name="code"
                          class="form-select form-control"
                          v-model="country"
                          required=""
                        >
                          <option value="" v-if="iteams">
                            --select Country--
                          </option>
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
                        <input
                          type="text"
                          class="form-control"
                          placeholder="EX:India"
                          v-model="zip"
                          required=""
                        />
                      </div> -->

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
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import countries from "./../../../assets/countries";
import slot from "./../../../assets/slot";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "AddBooking",
  data() {
    return {
      slot_type: "0",
      devices: "",
      device_id: "",
      users: {},
      // mobile: "",
      // address: "",
      time1: "",
      time3: "",
      error: null,
      iteams: countries,
      startslots: slot,
      endslots: slot,
      code: "",
      user_id: "",
      // city: "",
      // state: "",
      // country: "",
      // zip: "",
      startSlot: "",
      endSlot: "",
    };
  },
  components: {
    Nav,
    DatePicker,
  },
  async created() {
        this.loading = true;
    const response = await axios.get("/api/get_device");
    console.log("response.data.data", response.data);
    this.devices = response.data.data;

    const result = await axios.get("/api/users");
    console.log("response.data.data", result.data);
    this.users = result.data.data;
        this.loading = false;
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        device_id: this.device_id,
        slot_type: this.slot_type,
        start_date: this.time1,
        range_date: this.time3,
        user_id: this.user_id,
        // address: this.address,
        // mobile: this.mobile,
        // code: this.code,
        // city: this.city,
        // state: this.state,
        // country: this.country,
        // zip: this.zip,
        start_time: this.startSlot,
        end_time: this.endSlot,
      };

      axios
        .post("/api/add_booking", input)
        .then((res) => {
          if (res.data.code == "200") {
            this.error = null;
            this.$toaster.success("Add record successfully.");
            this.$router.push("/booking");
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
<style>
</style>
