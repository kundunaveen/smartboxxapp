<template>
     <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Add Users</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">Add New User</div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <form role="form" @submit="handleSubmit">
                      <div class="form-group">
                        <label>Name</label>
                        <input
                          class="form-control"
                          placeholder="Enter Name"
                          v-model="name"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                          class="form-control"
                          placeholder="Enter Email"
                          v-model="email"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>Mobile</label>
                        <input
                          class="form-control"
                          placeholder="Enter Mobile"
                          v-model="phone"
                          required=""
                        />
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          v-model="address"
                          required=""
                        ></textarea>
                      </div>

                      <button type="submit" class="btn btn-default">Add</button>
                      <router-link
                        type="reset"
                        class="btn btn-default"
                        to="/users"
                      >
                        Back
                      </router-link>
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
import Nav from "./../layout/Nav.vue";
import axios from "axios";
export default{
     name: "AddBooking",
}


</script>
<style>

</style>
