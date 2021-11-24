<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Booking</h1>
        </div>
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
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import Nav from "./../layout/Nav.vue";
export default {
  name: "Booking",
  components: {
    Nav,
  },
};
</script>

<style>
</style>