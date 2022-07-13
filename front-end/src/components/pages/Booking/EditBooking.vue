<template>
  <div id="wrapper">

    <Nav />
        <div class="preloader" v-if="loading">
      <div class="cssload-speeding-wheel"></div>
    </div>
    <div class="page-wrapper">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading">Edit Booking <router-link
                        type="reset"
                           to="/booking"
                        class="btn btn-default cancel-bttnn back-new-bttn"
                      >
                        <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                      </router-link></div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="#" @submit.prevent="updateBooking">
                    <div class="form-body">
                      <!--h3 class="box-title">Edit Booking</h3-->
                      <p v-if="error" class="text-danger">{{ error }}</p>
                      <!--hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Select Smartboxx</label>
                            <select
                              name="device_id"
                              class="form-select form-control "
                              v-model="booking.device_id"
                              required=""
                              id="smart_box"
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
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Select Users</label>
                            <select
                              class="form-select form-control"
                              v-model="booking.user_id"
                              required=""
                              id="users"
                            >
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
                                    v-model="booking.slot_type"
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
                                    v-model="booking.slot_type"
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
                                  v-show="booking.slot_type === '0'"
                                >
                                  <label>Select Time</label>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <select
                                        name="start_slot"
                                        class="form-select form-control"
                                        v-model="editstart"
                                        required=""
                                      >
                                        <option value="">
                                          -- Start Time--
                                        </option>

                                        <option
                                          v-bind:value="
                                            slot.time + '' + slot.standard
                                          "
                                          v-for="slot in startslots"
                                          :key="slot.time + '' + slot.standard"
                                        >
                                          {{ slot.time }} {{ slot.standard }}
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
                                        <option value="">-- End TIme--</option>
                                        <option
                                          v-bind:value="
                                            slot.time + '' + slot.standard
                                          "
                                          v-for="slot in endslots"
                                          :key="slot.time + '' + slot.standard"
                                        >
                                          {{ slot.time }} {{ slot.standard }}
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

                                  <date-picker range v-model="endDate">
                                    range style="width: 100%" >
                                  </date-picker>
                                </div>
                              </div>
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
                        <i class="fa fa-check"></i> Update
                      </button>
                      <router-link
                        type="reset"
                        to="/booking"
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
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import axios from "axios";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import countries from "./../../../assets/countries";
import slot from "./../../../assets/slot";
import $ from "jquery";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "EditBooking",
  data() {
    return {
      booking: {},
      devices: "",
      range_date: this.endDate,
      endDate: "",
      error: null,
      iteams: countries,
      startslots: slot,
      endslots: slot,
      editstart: "",
      editend: "",
      users: {},
    };
  },
  methods: {
    updateBooking() {
      this.booking.range_date = this.endDate;
      axios
        .put(`/api/update_booking/${this.$route.params.id}`, this.booking)
        .then((res) => {
          if (res.data.success == true) {
            this.error = null;
            this.$toaster.success("Record update successfully.");
            this.$router.push("/booking");
          } else {
            this.$toaster.error(res.data.custom);
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
    this.loading = true;
    const response = await axios.get(
      `/api/view_booking/${this.$route.params.id}`
    );
    this.booking = response.data.data;
    this.editstart = response.data.data.start_time;
    this.editend = response.data.data.end_time;

    this.endDate = [
      new Date(response.data.data.start_date),
      new Date(response.data.data.end_date),
    ];

    const res = await axios.get("/api/get_device");
    this.devices = res.data.data;

    const result = await axios.get("/api/users");
    console.log("response.data.data", result.data);
    this.users = result.data.data;
    this.loading = false;

    setTimeout(() => {
      var val = $("#smart_box :selected").val();
      $("#smart_box").val(val);
      $("#smart_box").select2().trigger("change");
      // $("#smart_box").addClass("select2-container form-select form-control select2");

         var vall = $("#users :selected").val();
      $("#users").val(vall);
      $("#users").select2().trigger("change");
      // $("#users").addClass("select2-container form-select form-control select2");

      
    });
  },
};
</script>
<style>
</style>
