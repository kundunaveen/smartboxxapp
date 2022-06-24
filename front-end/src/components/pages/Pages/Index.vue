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
                      Page List
                      <router-link to="/add-page" class="active"
                        ><i class="fa fa-plus fa-fw"></i>
                        Add Page
                      </router-link>
                    </h3>
                    <div class="pull-right">
                      <!-- <form
                        role="form"
                        class="form-inline"
                        @submit="handleSubmit"
                      >
                        <div class="form-group mr-4">
                          <input
                            type="text"
                            name="search"
                            placeholder="search by city"
                            value=""
                            v-model="search"
                            class="form-control"
                          />
                        </div>

                        <div class="form-group" style="margin-left: 5px">
                          <button
                            type="submit"
                            class="btn btn-info btn-rounded"
                          >
                            Search
                          </button>
                          <button
                            type="reset"
                            class="btn btn-danger btn-rounded"
                            @click="clear()"
                          >
                            Clear
                          </button>
                        </div>
                      </form> -->
                    </div>
                    
                  </div>
                  <div class="clearfix"></div>
                  <div class="scrollable">
                    <div class="table-responsive">
                      <table class="table product-overview" id="myTable">
                        <thead>
                          <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Title</th>

                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody v-if="pages">
                          <tr v-for="(state, index) in pages" :key="state.id">
                            <td class="text-center">{{ index + 1 }}</td>

                            <td class="text-center">{{ state.title }}</td>

                            <td class="text-center">
                              <div class="btn-group" role="group">
                                <router-link
                                  :to="{
                                    name: 'page-edit',
                                    params: { id: state.id },
                                  }"
                                  class="text-inverse m-r-5 btn btn-info"
                                  ><i class="ti-marker-alt"></i
                                ></router-link>
                                <a
                                  href="javascript:void(0)"
                                  @click="deletePage(state.id)"
                                  class="text-inverse m-r-5 btn btn-danger"
                                >
                                  <i class="ti-trash"></i>
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
        </div>
        <!--row -->
      </div>
      <!-- /.container-fluid -->
    </div>
  </div>
</template>

<script>
import swal from "sweetalert";
import axios from "axios";
import Nav from "../../layout/Nav.vue";
// import Head from "../../layout/Head.vue";

export default {
  name: "PageList",
  components: {
    Nav,
    // Head,
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
    deletePage(id) {
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