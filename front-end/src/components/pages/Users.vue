<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <Head />
        <div class="pull-right">
          <router-link to="/add-user" class="active"><i class="fa fa-plus fa-fw"></i>
          <i class="fa fa-user fa-fw"></i> Add User
          </router-link>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody v-if='users'>
                <tr v-for="(user, index) in users" :key="user.id">
                  <td>{{ index+1 }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                  <input type="checkbox" v-bind:checked="user.status =='1'" data-toggle="toggle" data-size="xs" @change="check(user.id)">

                  </td>

                  <td>
                    <div class="btn-group" role="group">
                      <router-link
                        :to="{ name: 'edit', params: { id: user.id } }"
                        
                        >Edit</router-link
                      >
                      <a href="javascript:void(0)"
                        
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
                 <td> No record found !</td>
                </tr>
              </tbody>
            </table>
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
import axios from "axios";



export default {
  name: "Users",
  data() {
    return {
      users: [],
    };
  },
  components: {
    Nav,
    Head,
  },
  methods: {
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
          });
        } else {
          swal("Your Record safe now!");
        }
      });
    },
    check(id){
        axios.put(`/api/status_change/${id}`).then(() => {
           swal("Status update!", "Status has been change!", "success");

         
          });
    }
    ,
  },
  async created() {
    const response = await axios.get("/api/users");
    console.log("response.data.data", response.data);
    this.users = response.data.data;
  },
};


</script>

<style>

</style>