<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Edit Users</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">Edit User<router-link
                        type="reset"
                        
                        to="/users"
                      >
                        Back
                      </router-link></div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <form role="form" @submit.prevent="updateProduct">
                      <div class="form-group">
                        <label>Name</label>
                        <input
                          class="form-control"
                          placeholder="Enter Name"
                          v-model="user.name"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input
                          class="form-control"
                          placeholder="Enter Email"
                          v-model="user.email"
                          required=""
                        />
                      </div>
                      <div class="form-group">
                        <label>Mobile</label>
                        <input
                        type="number"
                          class="form-control"
                          placeholder="Enter Mobile"
                          v-model="user.phone"
                          required=""
                        />
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          v-model="user.address"
                          required=""
                        >
                        {user.address}
                        </textarea>
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
import Nav from "./../layout/Nav.vue";
import axios from "axios";
export default {
  name: "EditUser",
  data() {
    return {
      user: {},
    };
  },
  async created() {
    const response = await axios.get(`/api/get_user/${this.$route.params.id}`);
    console.log("test", response);
    this.user = response.data.data;
  },
  methods: {
    updateProduct() {
      axios
        .put(
          `/api/update_user/${this.$route.params.id}`,
          this.user
        )
        .then(() => {

             this.$router.push('/users');
        });
    },
  },
  components: {
    Nav,
  },
};
</script>

<style>
</style>