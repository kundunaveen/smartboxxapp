<template>
  <div id="wrapper">
    <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <Head :msg="message" />
        <div class="pull-right">
          <router-link to="/add-country" class="active"
            ><i class="fa fa-plus fa-fw"></i>
            <i class="fa fa-flag fa-fw"></i> Add
          </router-link>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <table class="table" id="datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Dial Code</th>
                  <th>Code</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody v-if="countries">
                <tr v-for="(country, index) in countries" :key="country.id">
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
                  <td>No record found !</td>
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
    check(id) {
      axios.put(`/api/device_status_change/${id}`).then(() => {
        swal("Status update!", "Status has been change!", "success");
        this.$toaster.success("Status has been change! successfully.");
      });
    },
  },
};
</script>