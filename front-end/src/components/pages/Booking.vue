<template>
  <div id="wrapper">
    <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <Head :msg="message" />
        <div class="row">
          <div class="col-lg-12">
            <div class="pull-left">
              <form role="form" class="form-inline" @submit="handleSubmit">
                <div class="form-group mr-4">
                  <input
                    type="text"
                    name="search"
                    placeholder="search by UUID"
                    value=""
                    v-model="search"
                    class="form-control"
                  />
                </div>

                <div class="form-group" style="margin-left: 5px">
                  <button type="submit" class="btn btn-info btn-default">
                    Search</button
                  ><button
                    type="reset"
                    class="btn btn-danger btn-default"
                    @click="clear()"
                  >
                    Clear
                  </button>
                </div>
              </form>
            </div>
            <div class="pull-right">
              <router-link to="/add-booking" class="active"
                ><i class="fa fa-plus fa-fw"></i>
                <i class="fa fa-ticket fa-fw"></i> Add Booking
              </router-link>
            </div>
          </div>
        </div>
        <hr />

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading mypnl_heading">
                <span>Booking</span>
              </div>
              <table
                class="table table-bordered table-responsive"
                id="datatable"
              >
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
                  <tr v-for="(booking, index) in bookings" :key="booking.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ booking.uuid }}</td>
                    <td>{{ booking.device.name }}</td>
                    <td>
                      {{ booking.start_date }} / {{ booking.start_time }} to
                      {{ booking.end_time
                      }}<span v-if="booking.end_date">
                        to {{ booking.end_date }}</span
                      >
                    </td>
                    <td >
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
                        >Edit</router-link
                      >
                      <a
                        href="javascript:void(0)"
                        @click="deleteBooking(booking.id)"
                      >
                        Delete
                      </a>
                    </td>
                  </tr>
                </tbody>
                <tbody v-if="!bookings.length">
                  <tr>
                    <td>No record found !</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import swal from "sweetalert";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import Nav from "./../layout/Nav.vue";
import Head from "./../layout/Head.vue";
import axios from "axios";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "Booking",
  components: {
    Nav,
    Head,
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
    this.loading = false;
  },
};
</script>

<style>
</style>