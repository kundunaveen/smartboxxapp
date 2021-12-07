<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
          <Head :msg="message"/>
          <div class="pull-right">
          <router-link to="/add-booking" class="active"
            ><i class="fa fa-plus fa-fw"></i>
            <i class="fa fa-ticket fa-fw"></i> Add Booking
          </router-link>
        </div>
        <table class="table" id="datatable">
          <thead>
            <tr>
              <th>ID</th>
                <th>UUID</th>
              <th>Device Type</th>
              <th>Booking Date/Time</th>

              <th>Status</th>
              <th>Address</th>
              <th>Action</th>
            </tr>
          </thead>
            <tbody v-if='bookings'>
                <tr v-for="(booking, index) in bookings" :key="booking.id">
                  <td>{{ index+1 }}</td>
                  <td>{{ booking.uuid }}</td>
                  <td>{{ booking.device.name }}</td>
                   <td>{{ booking.start_date }} / {{ booking.start_time}} to {{ booking.end_time }}<span v-if="booking.end_date"> to {{booking.end_date }}</span></td>
                     <td><button type="button" class="btn btn-success">{{booking.status }}</button></td>
                   <td>{{ booking.address }}</td>
                  <td>
                  
                  </td>

                  <td>
                    <div class="btn-group" role="group">
                      <router-link
                        :to="{ name: 'bookingedit', params: { id: booking.id } }"
                        
                        >Edit</router-link
                      >
                      <a href="javascript:void(0)"
                        
                        @click="deleteBooking(booking.id)"
                      >
                        Delete
                      </a>
                      
                    </div>
                  </td>
                </tr>
              </tbody>
                 <tbody v-if="!bookings.length">
                <tr>
                 <td> No record found !</td>
                </tr>
              </tbody>
        </table>
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
import Vue from 'vue' 
import Toaster from 'v-toaster' 
import 'v-toaster/dist/v-toaster.css'
 Vue.use(Toaster, {timeout: 5000})

export default {
  name: "Booking",
  components: {
    Nav,
    Head
  },
  data(){
    return{
        bookings:[],
        message: "Booking"
    }
  },
  methods:{
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
            this.$toaster.success('Record delete successfully.')
          });
        } else {
          swal("Your Record safe now!");
        }
      });
    }
  },
   async created() {
    const response = await axios.get("/api/get_booking");
    console.log("response.data.data", response.data);
    this.bookings = response.data.data;
  },
};
</script>

<style>
</style>