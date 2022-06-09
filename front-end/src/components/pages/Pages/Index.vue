<template>
  <div id="wrapper">
    <div v-if="loading" class="loader"></div>
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <Head :msg="message" />
        <div class="pull-right">
          <router-link to="/add-page" class="active"
            ><i class="fa fa-plus fa-fw"></i>
            <i class="fa fa-flag fa-fw"></i> Add
          </router-link>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading mypnl_heading">
                <span>Pages</span>
              </div>
              <table
                class="table table-bordered table-responsive"
                id="datatable"
              >
                <thead>
                  <tr>
                   <th class="text-center">ID</th>
                   <th class="text-center">Page Type</th>

                   <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody v-if="pages">
                  <tr v-for="(state, index) in pages" :key="state.id">
                   <td class="text-center">{{ index + 1 }}</td>

                   <td class="text-center">{{ state.page_type.name }}</td>

                   <td class="text-center">
                      <div class="btn-group" role="group">
                        <router-link
                          :to="{
                            name: 'page-edit',
                            params: { id: state.id },
                          }"
                          >Edit</router-link
                        >
                        <a
                          href="javascript:void(0)"
                          @click="deleteDevice(state.id)"
                        >
                          Delete
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tbody v-if="!pages.length">
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
  name: "PageList",
  components: {
    Nav,
    Head,
  },

  data() {
    return {
      pages: [],
      message: "Pages",
      loading: false,
    };
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/page");

    this.pages = response.data.data;
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
          axios.delete(`/api/page/${id}`).then(() => {
            let i = this.pages.map((data) => data.id).indexOf(id);
            this.pages.splice(i, 1);
            this.$toaster.success("Record delete successfully.");
          });
        } else {
          swal("Your Record safe now!");
        }
      });
    },
  },
};
</script>