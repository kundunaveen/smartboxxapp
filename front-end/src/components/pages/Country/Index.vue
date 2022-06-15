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
                    placeholder="search by country"
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
              <router-link to="/add-country" class="active"
                ><i class="fa fa-plus fa-fw"></i>
                <i class="fa fa-flag fa-fw"></i> Add
              </router-link>
            </div>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading mypnl_heading">
                <span>Country</span>
              </div>
              <table
                class="table table-bordered table-responsive"
                id="datatable"
              >
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
                  <tr v-for="(country, index) in countries" :key="country.id">
                    <td class="text-center">{{ index + 1 }}</td>
                    <td class="text-center">{{ country.name }}</td>
                    <td class="text-center">{{ country.dial_code }}</td>
                    <td class="text-center">{{ country.code }}</td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        <router-link
                          :to="{
                            name: 'country-edit',
                            params: { id: country.id },
                          }"
                          >Edit</router-link
                        >
                        <a
                          href="javascript:void(0)"
                          @click="deleteDevice(country.id)"
                        >
                          Delete
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tbody v-if="!countries.length">
                  <tr>
                    <td class="text-center">No record found !</td>
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
import Nav from "../../layout/Nav.vue";
import Head from "../../layout/Head.vue";

export default {
  name: "CountryList",
  components: {
    Nav,
    Head,
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