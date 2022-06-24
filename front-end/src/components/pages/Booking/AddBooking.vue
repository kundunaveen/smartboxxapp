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
              <div class="panel-heading">Add Booking <router-link
                        type="reset"
                        to=""
                        class="btn btn-default cancel-bttnn back-new-bttn"
                      >
                        <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                      </router-link></div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit.prevent="handleSubmit">
                    <div class="form-body">
                      <!--h3 class="box-title">Add Booking</h3-->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!--hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Select Smartbox</label>
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
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
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
                        </div>
                        <!--/span-->
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Select Days</label>
                            <div class="radio-list">
                              <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                  <input
                                    type="radio"
                                    name="optionsRadios"
                                    id="radio1"
                                    value="0"
                                    checked=""
                                    v-model="slot_type"
                                  />
                                  <label for="radio1">Single Day</label>
                                </div>
                              </label>
                              <label class="radio-inline">
                                <div class="radio radio-info">
                                  <input
                                    type="radio"
                                    name="optionsRadios"
                                    id="radio2"
                                    value="1"
                                    v-model="slot_type"
                                  />
                                  <label for="radio2">Multiple Day</label>
                                </div>
                              </label>
                            </div>
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="col-lg-6" v-show="slot_type === '0'">
                              <label>Single Day</label>
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
                        <!--/span-->
                      </div>

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
                        to="/users"
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
