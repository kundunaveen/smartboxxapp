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
            <div class="white-box p-0">
              <!-- .left-right-aside-column-->
              <div class="page-aside">
                <div class="right-aside">
                  <div class="right-page-header top-heading-management">
                  <h3 class="box-title">
                      Booking Managment
                      
                      <router-link to="/add-booking" class="active"
                        ><i class="fa fa-plus fa-fw"></i> Add Booking
                      </router-link>
                    </h3>
                    <div class="pull-right">
                      <form
                        role="form"
                        class="form-inline"
                        @submit="handleSubmit"
                      >
                        <div class="form-group mr-4 m-r-5">
                          <input
                            type="text"
                            name="search"
                            placeholder="search by UUID"
                            value=""
                            v-model="search"
                            class="form-control"
                          />
                        </div>

                        <div class="form-group m-r-5">
                          <button
                            type="submit"
                            class="btn btn-info btn-rounded m-r-5 "
                          >
                            <i class="fa fa-search" aria-hidden="true"></i> Search
                          </button>
                          <button
                            type="reset"
                            class="btn btn-danger btn-rounded cancel-bttnn"
                            @click="clear()"
                          >
                            <i class="fa fa-times" aria-hidden="true"></i> Clear
                          </button>
                        </div>
                      </form>
                    </div>
                    
                  </div>
                  <div class="clearfix"></div>
                  <div class="scrollable">
                    <div class="table-responsive">
                      <table class="table product-overview" id="datatable">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>UUID</th>
                            <th>Device Type</th>
                            <th>Booking Date/Time</th>

                            <th>Status</th>

                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody v-if="bookings">
                          <tr
                            v-for="(booking, index) in bookings"
                            :key="booking.id"
                          >
                            <td>{{ index + 1 }}</td>
                            <td>{{ booking.uuid }}</td>
                            <td>{{ booking.device.name }}</td>
                            <td v-if="booking.slot_type=='1'">
                              {{ booking.start_date }}<span v-if="booking.end_date">
                                to {{ booking.end_date }}</span
                              >
                            </td>
                            <td v-if="booking.slot_type=='0'">
                              {{ booking.start_date }} /
                              {{ booking.start_time }} to {{ booking.end_time
                              }}
                            </td>
                            <td>
                              <button type="button" class="btn btn-success">
                                {{ booking.status }}
                              </button>
                            </td>

                            <td>
                              <router-link
                                :to="{
                                  name: 'bookingedit',
                                  params: { id: booking.id },
                                }"
                                class="text-inverse m-r-5 btn btn-info"
                                ><i class="ti-marker-alt"></i
                              ></router-link>
                              <a
                                href="javascript:void(0)"
                                @click="deleteBooking(booking.id)"
                                class="text-inverse m-r-5 btn btn-danger"
                              >
                                <i class="ti-trash"></i>
                              </a>
                            </td>
                          </tr>
                        </tbody>
                        <tbody v-if="!bookings.length"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--row -->
      </div>
      <!-- /.container-fluid -->
    </div>
  </div>
</template>
<script>
import "jquery/dist/jquery.min.js";
import swal from "sweetalert";

import Nav from "./../layout/Nav.vue";
// import Head from "./../layout/Head.vue";
import axios from "axios";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
import Vue from "vue";

import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "Booking",
  components: {
    Nav,
    // Head,
  },
  data() {
    return {
      bookings: [],
      message: "Booking",
      loading: false,
      search: "",
    };
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();
      let input = new FormData();
      input.append("search", this.search);

      this.loading = true;

      axios
        .get("/api/get_booking", {
          params: {
            search: this.search,
          },
        })
        .then((res) => {
          if (res.data.success == true) {
            this.bookings = res.data.data;
          } else {
            this.error = res.data.message;
            this.$toaster.error(res.data.message);
          }
        })
        .catch((err) => {
          // console.log(err.errors);
          this.$toaster.error(err.errors);
          this.error = "Record not save please check";
        });
      this.loading = false;
    },
    deleteBooking(id) {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover !",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          axios.delete(`/api/booking_delete/${id}`).then(() => {
            let i = this.bookings.map((data) => data.id).indexOf(id);
            this.bookings.splice(i, 1);
            this.$toaster.success("Record delete successfully.");
          });
        } else {
          swal("Your Record safe now!");
        }
      });
    },
    clear() {
      this.loading = true;
      (this.search = null),
        axios
          .get("/api/get_booking")
          .then((res) => {
            if (res.data.success == true) {
              this.bookings = res.data.data;
            } else {
              this.error = res.data.message;
              this.$toaster.error(res.data.message);
            }
          })
          .catch((err) => {
            // console.log(err.errors);
            this.$toaster.error(err.errors);
            this.error = "Record not save please check";
          });

      this.loading = false;
    },
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/get_booking");
    console.log("response.data.data", response.data);
    this.bookings = response.data.data;
    setTimeout(() => {
      $("#datatable").DataTable({
        pageLength: 15,
        bLengthChange: false,
        filter: false,
        bInfo: false,
        sort: false,
      });
    });
    this.loading = false;
  },
};
</script>

<style>
</style>