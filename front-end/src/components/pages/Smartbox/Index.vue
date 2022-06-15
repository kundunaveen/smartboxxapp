<template>
  <div id="wrapper">
    <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <Head :msg="message" />
        <div class="row">
          <div class="col-lg-12">
            <div class="pull-left">
              <form role="form" class="form-inline" @submit="handleSubmit">
                <div class="form-group mr-4">
                  <input
                    type="text"
                    name="search"
                    placeholder="search by name"
                    value=""
                    v-model="search"
                    class="form-control"
                  />
                </div>

                <div class="form-group" style="margin-left: 5px">
                  <button type="submit" class="btn btn-info btn-default">
                    Search</button
                  ><button
                    type="reset"
                    class="btn btn-danger btn-default"
                    @click="clear()"
                  >
                    Clear
                  </button>
                </div>
              </form>
            </div>
            <div class="pull-right">
              <router-link to="/add-smartbox" class="active"
                ><i class="fa fa-plus fa-fw"></i>
                <i class="fa fa-user fa-fw"></i> Add Box
              </router-link>
            </div>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading mypnl_heading">
                <span>Smartbox</span>
              </div>
              <table
                class="table table-bordered table-responsive"
                id="datatable"
              >
                <thead>
                  <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody v-if="devices">
                  <tr v-for="(device, index) in devices" :key="device.id">
                    <td class="text-center">{{ index + 1 }}</td>
                    <td class="text-center">{{ device.name }}</td>
                    <td class="text-center">
                      <input
                        type="checkbox"
                        v-bind:checked="device.status == 'active'"
                        data-toggle="toggle"
                        data-size="xs"
                        @change="check(device.id)"
                      />
                    </td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        <router-link
                          :to="{
                            name: 'device-edit',
                            params: { id: device.id },
                          }"
                          >Edit</router-link
                        >
                        <a
                          href="javascript:void(0)"
                          @click="deleteDevice(device.id)"
                        >
                          Delete
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tbody v-if="!devices.length">
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
import axios from "axios";
import Nav from "./../../layout/Nav.vue";
import Head from "./../../layout/Head.vue";

export default {
  name: "SmartBoxList",
  components: {
    Nav,
    Head,
  },

  data() {
    return {
      devices: [],
      message: "Smartbox",
      loading: false,
    };
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/device_list");
    console.log("response.data.data", response.data);
    this.devices = response.data.data;
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