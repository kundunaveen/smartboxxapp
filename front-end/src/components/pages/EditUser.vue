<template>
  <div id="wrapper">
      <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Edit Users</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <router-link type="reset" to="/users"> Back </router-link> Edit
                User
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-6 col-lg-offset-3 col-lg-6">
                    <form role="form" @submit.prevent="updateUser">
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

                        <div class="row">
                          <div class="col-lg-6">
                            <select
                              name="code"
                              class="form-select form-control"
                              v-model="user.code"
                              required=""
                            >
                              <option value="" v-if="iteams">Country</option>
                              <option
                                v-bind:value="iteam.dial_code"
                                v-for="iteam in iteams"
                                :key="iteam.code"
                              >
                                {{ iteam.name }} {{ iteam.dial_code }}
                              </option>
                            </select>
                          </div>
                          <div class="col-lg-6">
                            <input
                              type="number"
                              class="form-control"
                              placeholder="EX: 7737719645"
                              v-model="user.phone"
                              required=""
                            />
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6">
                            <label>Street</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder="EX:877 Mulberry Lane"
                              v-model="user.address"
                              required=""
                            />
                          </div>
                          <div class="col-lg-6">
                            <label>City</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder="EX:877 Mulberry Lane"
                              v-model="user.city"
                              required=""
                            />
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6">
                            <label>State</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder="EX: Dehli"
                              v-model="user.state"
                              required=""
                            />
                          </div>
                          <div class="col-lg-6">
                            <label>Country</label>
                            <select
                              name="code"
                              class="form-select form-control"
                              v-model="user.country"
                              required=""
                            >
                              <option value="" v-if="iteams">
                                --select Country--
                              </option>
                              <option
                                v-bind:value="iteam.name"
                                v-for="iteam in iteams"
                                :key="iteam.code"
                              >
                                {{ iteam.name }}
                              </option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Zip</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="EX:India"
                          v-model="user.zip"
                          required=""
                        />
                      </div>
                      <div class="checkbox">
                        <label>
                          <input
                            type="checkbox"
                            v-bind:checked="user.status == '1'"
                            data-toggle="toggle"
                            data-size="xs"
                          
                           @change="onChange"
                          />

                          Enable
                        </label>
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
import countries from "./../../assets/countries";
import Vue from "vue";
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

export default {
  name: "EditUser",
  data() {
    return {
      user: {},
      iteams: countries,
    };
  },
  async created() {
        this.loading = true;
    if (`${this.$route.params.id}` !== "undefined") {
      
      url1 = `/api/get_user/${this.$route.params.id}`;
    } else {
      var url1 = `/api/get_user`;
    }

    const response = await axios.get(url1);
    this.user = response.data.data;
       this.loading = false;
  },
  methods: {
    updateUser() {
      console.log(" this.user", this.user);
      if (`${this.$route.params.id}` !== "undefined") {
        url = `/api/update_user/${this.$route.params.id}`;
        axios.put(url, this.user).then(() => {
          this.$toaster.success("Record update successfully.");
          this.$router.push("/users");
        });
      } else {
        var url = `/api/update_user`;
        axios.post(url, this.user).then(() => {
          this.$toaster.success("Record update successfully.");
          this.$router.push("/edit");
        });
      }
    },
     onChange(e) {
 
      this.user.status = e.target.checked == true ? 1 : 0;
   
    }
  },
  components: {
    Nav,
  },
};
</script>

<style>
</style>