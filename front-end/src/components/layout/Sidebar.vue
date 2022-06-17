<template>

</template>

<script>
import axios from "axios";
export default {
  name: "Sidebar",
  methods: {
    handleClick() {
      localStorage.removeItem("token");
      this.$router.push("/");
    },
  },
  data() {
    return {
      user: null,
    };
  },
  async created() {
    const response = await axios.get("/api/get_details");
    this.user = response.data.data;
  },
};
</script>

<style>
</style>