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
                      Smartboxx
                      <router-link to="/add-smartbox" class="active"
                        ><i class="fa fa-plus fa-fw"></i>
                        Add
                      </router-link>
                    </h3>
                    <div class="pull-right">
                      <form
                        role="form"
                        class="form-inline"
                        @submit="handleSubmit"
                      >
                        <div class="form-group mr-4 m-r-5">
                          <input
                            type="text"
                            name="search"
                            placeholder="search by name"
                            value=""
                            v-model="search"
                            class="form-control"
                          />
                        </div>

                        <div class="form-group">
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
                        </div>
                      </form>
                    </div>
                    
                  </div>
                  <div class="clearfix"></div>
                  <div class="scrollable">
                    <div class="table-responsive">
                      <table class="table" id="datatable">
                         <thead>
                          <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                          </tr>
                      </thead>
                        <tbody v-if="devices">
                          <tr
                            v-for="(device, index) in devices"
                            :key="device.id"
                          >
                            <td >{{ index + 1 }}</td>
                            <td>{{ device.name }}</td>
                            <td>
                              <input
                                type="checkbox" class="input-new-style"
                                v-bind:checked="device.status == 'active'"
                                data-toggle="toggle"
                                data-size="xs"
                                @change="check(device.id)"
                              />
                            </td>
                            <td>
                              <div class="btn-group" role="group">
                                <router-link
                                  :to="{
                                    name: 'device-edit',
                                    params: { id: device.id },
                                  }"
                                  class="text-inverse m-r-5 btn btn-info"
                                  ><i class="ti-marker-alt"></i
                                ></router-link>
                                <a
                                  href="javascript:void(0)"
                                  class="text-inverse m-r-5 btn btn-danger"
                                  @click="deleteDevice(device.id)"
                                >
                                  <i class="ti-trash"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                        <tbody v-if="!devices.length"></tbody>
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
import "jquery/dist/jquery.min.js";
import swal from "sweetalert";

import axios from "axios";
import Nav from "./../../layout/Nav.vue";

import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
// import Head from "./../../layout/Head.vue";

export default {
  name: "SmartBoxList",
  components: {
    Nav,
    // Head,
  },

  data() {
    return {
      devices: [],
      message: "Smartbox",
      loading: false,
      search: "",
    };
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/device_list");
    console.log("response.data.data", response.data);
    this.devices = response.data.data;

    setTimeout(() => {
      $("#datatable").DataTable({
        pageLength: 15,
        bLengthChange: false,
        filter: false,
        bInfo: false,
        sort: false,
      });
    });
    this.loading = false;
  },
  methods: {
    deleteDevice(id) {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover !",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          axios.delete(`/api/device_delete/${id}`).then(() => {
            let i = this.devices.map((data) => data.id).indexOf(id);
            this.devices.splice(i, 1);
            this.$toaster.success("Record delete successfully.");
          });
        } else {
          swal("Your Record safe now!");
        }
      });
    },
    check(id) {
      axios.put(`/api/device_status_change/${id}`).then(() => {
        swal("Status update!", "Status has been change!", "success");
        this.$toaster.success("Status has been change! successfully.");
      });
    },
    async handleSubmit(e) {
      e.preventDefault();

      let input = new FormData();
      input.append("search", this.search);

      this.loading = true;

      axios
        .get("/api/device_list", {
          params: {
            search: this.search,
          },
        })
        .then((res) => {
          if (res.data.success == true) {
            this.devices = res.data.data;
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
    clear() {
      this.loading = true;
      (this.search = null),
        axios
          .get("/api/device_list")
          .then((res) => {
            if (res.data.success == true) {
              this.devices = res.data.data;
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
};
</script>