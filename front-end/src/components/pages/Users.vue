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
                      Users Managment
                     
                      <router-link to="/add-user" class="active"
                        ><i class="fa fa-plus fa-fw"></i>
                        Add User
                      </router-link>
                    </h3>
                    <div class="pull-right">
                      <form
                        role="form"
                        @submit="handleSubmit"
                        class="form-inline"
                      >
                        <div class="form-group mr-4 m-r-5">
                          <input
                            type="text"
                            class="form-control"
                            name="search"
                            v-model="search"
                            placeholder="name,mobile number,email"
                            value=""
                          />
                        </div>

                        <div class="form-group m-r-5" >
                          <select
                            class="form-control"
                            name="type"
                            v-model="status"
                          >
                            <option value="">--status type--</option>
                            <option value="1">Acitve</option>
                            <option value="0">In-Active</option>
                          </select>
                        </div>

                        <div class="form-group " >
                          <button
                            type="submit"
                            class="btn btn-info btn-rounded m-r-5"
                            
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
                          <!-- <router-link
                    :to="{ name: 'USERS', force: true }"
                    class="btn btn-danger btn-default"
                  >
                    Clear</router-link
                  > -->
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody v-if="users">
                          <tr v-for="(user, index) in users" :key="user.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                              <input
                                type="checkbox" class="input-new-style"
                                v-bind:checked="user.status == '1'"
                                data-toggle="toggle"
                                data-size="xs"
                                @change="check(user.id)"
                              />
                            </td>

                            <td>
                              <div class="btn-group" role="group">
                                <router-link
                                  :to="{
                                    name: 'edit',
                                    params: { id: user.id },
                                  }"
                                  class="text-inverse m-r-5 btn btn-info"
                                  ><i class="ti-marker-alt"></i
                                ></router-link>
                                
                                <a
                                  href="javascript:void(0)"
                                  @click="deleteUser(user.id)"
                                  class="text-inverse m-r-5 btn btn-danger"
                                >
                                  <i class="ti-trash"></i>
                                </a>
                                <router-link
                                  :to="{
                                    name: 'pass',
                                    params: { id: user.id },
                                  }"
                                  class="text-inverse m-r-5 btn btn-primary"
                                  ><i class="ti-lock"></i
                                ></router-link>
                              </div>
                            </td>
                          </tr>
                        </tbody>
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
import swal from "sweetalert";
import "jquery/dist/jquery.min.js";

import Nav from "./../layout/Nav.vue";
// import Head from "./../layout/Head.vue";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import axios from "axios";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";

Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "Users",
  data() {
    return {
      users: [],
      message: "Users",
      loading: false,
      search: "",
      status: "",
    };
  },
  components: {
    Nav,
    // Head,
  },
  methods: {
    async handleSubmit(e) {
      e.preventDefault();

      const input = {
        search: this.search,
        status: this.status,
      };
      this.loading = true;
      axios
        .post("/api/search", input)
        .then((res) => {
          if (res.data.success == true) {
            this.users = res.data.data;
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
    deleteUser(id) {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover !",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          axios.get(`/api/move_to_trash/${id}`).then(() => {
            this.$router.push("/users");
            let i = this.users.map((data) => data.id).indexOf(id);
            this.users.splice(i, 1);
            this.$toaster.success("Record delete successfully.");
          });
        } else {
          swal("Your Record safe now!");
        }
      });
    },
    check(id) {
      axios.put(`/api/status_change/${id}`).then(() => {
        swal("Status update!", "Status has been change!", "success");
        this.$toaster.success("Status has been change! successfully.");
      });
    },
    clear() {
      this.loading = true;
      (this.search = null),
        axios
          .get("/api/users")
          .then((res) => {
            if (res.data.success == true) {
              this.users = res.data.data;
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
    const response = await axios.get("/api/users");
    setTimeout(() => {
      $("#datatable").DataTable({
        pageLength: 15,
        bLengthChange: false,
        filter: false,
        bInfo: false,
        sort: false,
      });
    });
    this.users = response.data.data;
    this.loading = false;
  },
};
</script>

<style>
</style>