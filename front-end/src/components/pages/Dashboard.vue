<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
        <div class="col-lg-12">
          <h1 class="page-header">Dashboard</h1>
        </div>
        
      </div>
    </div>
  </div>
</template>
<script>
import Nav from "./../layout/Nav.vue";
export default {
  name: "Dashboard",
  components: {
    Nav,
  },
};
</script>

<style>
</style>