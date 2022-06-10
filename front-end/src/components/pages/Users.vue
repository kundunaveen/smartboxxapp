<template>
  <div id="wrapper">
    <Nav />
    <div v-if="loading" class="loader">
      <!-- here put a spinner or whatever you want to indicate that a request is in progress -->
    </div>
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <Head :msg="message" />
        <div class="row">
          <div class="col-lg-12">
            <div class="pull-left">
              <form role="form" @submit="handleSubmit" class="form-inline">
                <div class="form-group mr-4">
                  <input
                    type="text"
                    class="form-control"
                    name="search"
                    v-model="search"
                    placeholder="name,mobile number,email"
                    value=""
                  />
                </div>

                <div class="form-group" style="margin-left: 5px">
                  <select class="form-control" name="type" v-model="status">
                    <option value="">--status type--</option>
                    <option value="1">Acitve</option>
                    <option value="0">In-Active</option>
                  </select>
                </div>

                <div class="form-group" style="margin-left: 5px">
                  <button type="submit" class="btn btn-info btn-default">
                    Search
                  </button>
                  <button
                    type="reset"
                    class="btn btn-danger btn-default"
                    @click="clear()"
                  >
                    Clear
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
            <div class="pull-right">
              <router-link to="/add-user" class="active"
                ><i class="fa fa-plus fa-fw"></i>
                <i class="fa fa-user fa-fw"></i> Add User
              </router-link>
            </div>
          </div>
        </div>
        <hr />

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading mypnl_heading">
                <span>Users</span>
              </div>
              <table
                class="table table-bordered table-responsive"
                id="datatable"
              >
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
                        type="checkbox"
                        v-bind:checked="user.status == '1'"
                        data-toggle="toggle"
                        data-size="xs"
                        @change="check(user.id)"
                      />
                    </td>

                    <td>
                      <div class="btn-group" role="group">
                        <router-link
                          :to="{ name: 'edit', params: { id: user.id } }"
                          >Edit</router-link
                        >
                        <a
                          href="javascript:void(0)"
                          @click="deleteUser(user.id)"
                        >
                          Delete
                        </a>
                        <router-link
                          :to="{ name: 'pass', params: { id: user.id } }"
                          >password</router-link
                        >
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tbody v-if="!users.length">
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

import Nav from "./../layout/Nav.vue";
import Head from "./../layout/Head.vue";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
import axios from "axios";

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
    Head,
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
        this.search=null,
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

    this.users = response.data.data;
    this.loading = false;
  },
};
</script>

<style>
</style>