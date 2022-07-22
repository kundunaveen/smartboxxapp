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
              <div class="panel-heading">
                View Booking
                <router-link
                  type="reset"
                  to="/booking"
                  class="btn btn-default cancel-bttnn back-new-bttn"
                >
                  <i class="fa fa-chevron-left" aria-hidden="true"></i> Back
                </router-link>
              </div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
            
                    <div class="form-body">
                      <!--h3 class="box-title">Edit Booking</h3-->
                      <!--hr /-->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                           <p>Booking Id : {{booking.uuid}}</p>                            
                            <p>Smartboxx Name : {{booking.device.name}}</p>
                            <p>User Name : {{booking.user.name}} ( {{booking.user.email}} )</p>
                            <p v-show="booking.slot_type === '0'">Booking Days : Single Day  ({{booking.start_date }}  from {{booking.start_time +' - '+booking.end_time}})</p>
                            <p v-show="booking.slot_type === '1'">Booking Days : Multiple Day  ({{booking.start_date +' - '+ booking.end_date }}  from {{booking.start_time +' - '+booking.end_time}})</p>
                            <p>Payment Mode :  {{booking.mode}}</p> 
                            <p>Payment Type : {{booking.payment_method ? booking.payment_method : 'N/A'}}</p>
                            <p>Amount :  ${{booking.amount ? booking.amount : '0'}}</p>
                          </div>
                        </div>
                       
                      </div>
                     

                      <hr />
                       

                    </div>
                 

                    
              
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
// import $ from "jquery";
// import Select2 from 'v-select2-component';
import Nav from "./../../layout/Nav.vue";
// import DatePicker from "vue2-datepicker";
// import "vue2-datepicker/index.css";
import axios from "axios";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import countries from "./../../../assets/countries";
import slot from "./../../../assets/slot";

Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "EditBooking",
  data() {
    return {
      booking: {},
      // devices: [],
      selected: "",
      range_date: this.endDate,
      endDate: "",
      error: null,
      iteams: countries,
      startslots: slot,
      endslots: slot,
      editstart: "",
      editend: "",
      users: {},
      slot_type: "",
      time1: "",
      loading: false,
      device_id: "",
      selectedValue: "",
      devices: [],
    };
  },

  methods: {

     onChange(val) {
      this.device_id = val.id;
    },
    onChangeUser(val) {
      this.user_id = val.id;
    },
  },
  components: {
    Nav,
    // DatePicker,
    // Select2,
  },
  async created() {
    this.loading = true;
  

    const response = await axios.get(
      `/api/view_booking/${this.$route.params.id}`
    );
    this.booking = response.data.data;

    this.editstart = response.data.data.start_time;
    this.editend = response.data.data.end_time;
    // this.selectedValue = response.data.data.device_id;
    // this.selectedValue = [{ "id": 128, "text": "smart one" }]
    // this.selectedValue = ({id: 'EN', text: 'en', selected: ifSelected})

    this.endDate = [
      new Date(response.data.data.start_date),
      new Date(response.data.data.end_date),
    ];

 
  },
};
</script>
<style>
</style>