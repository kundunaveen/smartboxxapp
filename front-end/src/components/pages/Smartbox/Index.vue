<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
       <Head :msg="message"/>
        <div class="pull-right">
          <router-link to="/add-smartbox" class="active"><i class="fa fa-plus fa-fw"></i>
          <i class="fa fa-user fa-fw"></i> Add Box
          </router-link>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <table class="table" id="datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
                <tbody v-if='devices'>
                <tr v-for="(device, index) in devices" :key="device.id">
                  <td>{{ index+1 }}</td>
                  <td>{{ device.name }}</td>
                  <td><input type="checkbox" v-bind:checked="device.status =='active'" data-toggle="toggle" data-size="xs" @change="check(device.id)"></td>
                  <td>
                    <div class="btn-group" role="group">
                      <router-link
                        :to="{ name: 'device-edit', params: { id: device.id } }"
                        
                        >Edit</router-link
                      >
                      <a href="javascript:void(0)"
                        
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
import axios from "axios";
import Nav from "./../../layout/Nav.vue";
import Head from "./../../layout/Head.vue";

export default {
  name: "SmartBoxList",
   components: {
    Nav,
    Head,
  },
  
    data(){
    return{
        devices:[],
        message: "Smartbox"
    }
  },
  async created() {
    const response = await axios.get("/api/device_list");
    console.log("response.data.data", response.data);
    this.devices = response.data.data;
  },
   methods:{
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
            this.$toaster.success('Record delete successfully.')
          });
        } else {
          swal("Your Record safe now!");
        }
      });
    },
     check(id){
        axios.put(`/api/device_status_change/${id}`).then(() => {
           swal("Status update!", "Status has been change!", "success");
            this.$toaster.success('Status has been change! successfully.')

         
          });
    }
  },
}
</script>