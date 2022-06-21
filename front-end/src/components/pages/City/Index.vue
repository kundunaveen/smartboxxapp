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
                  <div class="right-page-header">
                    <div class="pull-right">
                      <form
                        role="form"
                        class="form-inline"
                        @submit="handleSubmit"
                      >
                        <div class="form-group mr-4  m-r-5 ">
                          <input
                            type="text"
                            name="search"
                            placeholder="search by city"
                            value=""
                            v-model="search"
                            class="form-control"
                          />
                        </div>

                        <div class="form-group  ">
                          <button
                            type="submit"
                            class="btn btn-info btn-rounded  m-r-5"
                          >
                            Search
                          </button>
                          <button
                            type="reset"
                            class="btn btn-danger btn-rounded  m-r-5 "
                            @click="clear()"
                          >
                            Clear
                          </button>
                        </div>
                      </form>
                    </div>
                    <h3 class="box-title">
                      City List
                      <br />
                      <router-link to="/add-city" class="active"
                        ><i class="fa fa-plus fa-fw"></i>
                        Add City
                      </router-link>
                    </h3>
                  </div>
                  <div class="clearfix"></div>
                  <div class="scrollable">
                    <div class="table-responsive">
                      <table class="table product-overview" id="datatable">
                        <thead>
                          <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Country</th>
                            <th class="text-center">State</th>
                            <th class="text-center">City</th>

                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody v-if="states">
                          <tr v-for="(state, index) in states" :key="state.id">
                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">
                              {{ state.country.name }}
                            </td>
                            <td class="text-center">{{ state.state.name }}</td>
                            <td class="text-center">{{ state.city }}</td>

                            <td class="text-center">
                              <div class="btn-group" role="group">
                                <router-link
                                  :to="{
                                    name: 'city-edit',
                                    params: { id: state.id },
                                  }"
                                  class="text-inverse m-r-5 btn btn-info"
                                  ><i class="ti-marker-alt"></i
                                ></router-link>
                                <a
                                  href="javascript:void(0)"
                                  @click="deleteDevice(state.id)"
                                  class="text-inverse m-r-5 btn btn-danger"
                                >
                                  <i class="ti-trash"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                        <tbody v-if="!states.length">
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
import Nav from "../../layout/Nav.vue";
// import Head from "../../layout/Head.vue";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";

export default {
  name: "stateList",
  components: {
    Nav,
    // Head,
  },

  data() {
    return {
      states: [],
      message: "City",
      loading: false,
      search: "",
    };
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/city");

    setTimeout(() => {
      $("#datatable").DataTable({
        // lengthMenu: [
        //   [5, 10, 25, 50, -1],
        //   [5, 10, 25, 50, "All"],
        // ],
        pageLength: 15,
        bLengthChange: false,
        filter: false,
        bInfo: false,
        sort: false,
      });
    });
    this.states = response.data.data;
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
          axios.delete(`/api/city/${id}`).then(() => {
            let i = this.states.map((data) => data.id).indexOf(id);
            this.states.splice(i, 1);
            this.$toaster.success("Record delete successfully.");
          });
        } else {
          swal("Your Record safe now!");
        }
      });
    },
    async handleSubmit(e) {
      e.preventDefault();

      let input = new FormData();
      input.append("search", this.search);

      this.loading = true;

      axios
        .get("/api/city", {
          params: {
            search: this.search,
          },
        })
        .then((res) => {
          if (res.data.success == true) {
            this.states = res.data.data;
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
          .get("/api/city")
          .then((res) => {
            if (res.data.success == true) {
              this.states = res.data.data;
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