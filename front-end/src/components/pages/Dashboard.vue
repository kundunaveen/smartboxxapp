<template>
  <div id="wrapper">
    <Nav />
    <div id="page-wrapper" style="min-height: 606px">
      <div class="container-fluid">
       <Head :msg="message"/>
         
      </div>
    </div>
  </div>
</template>
<script>
import Nav from "./../layout/Nav.vue";
import Head from "./../layout/Head.vue";

export default {
  name: "Dashboard",
  components: {
    Nav,
    Head
  },
   data() {
    return {
      message: "Dashboard"
    };
  },
};
</script>

<style>
</style>