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
                      Country List
                      <router-link to="/add-country" class="active"
                        ><i class="fa fa-plus fa-fw"></i>
                        Add Country
                      </router-link>
                    </h3>
                    <div class="pull-right">
                      <form
                        role="form"
                        class="form-inline"
                        @submit="handleSubmit"
                      >
                        <div class="form-group m-r-5">
                          <input
                            type="text"
                            name="search"
                            placeholder="search by country"
                            value=""
                            v-model="search"
                            class="form-control"
                          />
                        </div>

                        <div class="form-group m-r-5" >
                          <button
                            type="submit"
                            class="btn btn-info btn-rounded m-r-5"
                          >
                            <i class="fa fa-search" aria-hidden="true"></i> Search
                          </button>
                          <button
                            type="reset"
                            class="btn btn-danger btn-rounded m-r-5"
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
                      <table class="table product-overview" id="myTable">
                        <thead>
                          <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Dial Code</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody v-if="countries">
                          <tr
                            v-for="(country, index) in countries"
                            :key="country.id"
                          >
                            <td>{{ index + 1 }}</td>
                            <td>{{ country.name }}</td>
                            <td>{{ country.dial_code }}</td>
                            <td>{{ country.code }}</td>
                            <td>
                              <div class="btn-group" role="group">
                                <router-link
                                  :to="{
                                    name: 'country-edit',
                                    params: { id: country.id },
                                  }"
                                  class="text-inverse m-r-5 btn btn-info"
                                  ><i class="ti-marker-alt"></i
                                ></router-link>
                                <a
                                  href="javascript:void(0)"
                                  @click="deleteDevice(country.id)"
                                  class="text-inverse m-r-5 btn btn-danger"
                                >
                                  <i class="ti-trash"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                        <tbody v-if="!countries.length"></tbody>
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
  name: "CountryList",
  components: {
    Nav,
    // Head,
  },

  data() {
    return {
      countries: [],
      message: "Country",
      search: "",
    };
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/country");
    setTimeout(() => {
      $("#myTable").DataTable({
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
    this.countries = response.data.data;
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
          axios.delete(`/api/country/${id}`).then(() => {
            let i = this.countries.map((data) => data.id).indexOf(id);
            this.countries.splice(i, 1);
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
        .get("/api/country", {
          params: {
            search: this.search,
          },
        })
        .then((res) => {
          if (res.data.success == true) {
            this.countries = res.data.data;
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
          .get("/api/country")
          .then((res) => {
            if (res.data.success == true) {
              this.countries = res.data.data;
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