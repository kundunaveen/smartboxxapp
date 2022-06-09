<template>
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
      <router-link class="navbar-brand" to="/">smartboxxapp</router-link>
    </div>

    <button
      type="button"
      class="navbar-toggle"
      data-toggle="collapse"
      data-target=".navbar-collapse"
    >
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

    <ul class="nav navbar-nav navbar-left navbar-top-links">
      <li>
        <a href="#"><i class="fa fa-home fa-fw"></i> Website</a>
      </li>
    </ul>

    <ul class="nav navbar-right navbar-top-links">
      <li class="dropdown navbar-inverse">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
          <li>
            <a href="#">
              <div>
                <i class="fa fa-comment fa-fw"></i> New Comment
                <span class="pull-right text-muted small">4 minutes ago</span>
              </div>
            </a>
          </li>
          <li>
            <a href="#">
              <div>
                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                <span class="pull-right text-muted small">12 minutes ago</span>
              </div>
            </a>
          </li>
          <li>
            <a href="#">
              <div>
                <i class="fa fa-envelope fa-fw"></i> Message Sent
                <span class="pull-right text-muted small">4 minutes ago</span>
              </div>
            </a>
          </li>
          <li>
            <a href="#">
              <div>
                <i class="fa fa-tasks fa-fw"></i> New Task
                <span class="pull-right text-muted small">4 minutes ago</span>
              </div>
            </a>
          </li>
          <li>
            <a href="#">
              <div>
                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                <span class="pull-right text-muted small">4 minutes ago</span>
              </div>
            </a>
          </li>
          <li class="divider"></li>
          <li>
            <a class="text-center" href="#">
              <strong>See All Alerts</strong>
              <i class="fa fa-angle-right"></i>
            </a>
          </li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" v-if="user">
          <i class="fa fa-user fa-fw"></i>{{ user.name }}<b class="caret"></b>
        </a>
        <ul class="dropdown-menu dropdown-user">
          <li>
            <a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
          </li>
          <li>
            <router-link to="/change_pass" class="active"
              ><i class="fa fa-key fa-fw"></i> Change Password</router-link
            >
          </li>
          <li>
            <router-link to="/profile" class="active"
              ><i class="fa fa-user fa-fw"></i>Edit Profile</router-link
            >
          </li>
          <li>
            <a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
          </li>
          <li class="divider"></li>

          <li>
            <a href="javascript:void(0)" @click="handleClick"
              ><i class="fa fa-sign-out fa-fw"></i> Logout</a
            >
          </li>
        </ul>
      </li>
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse">
        <ul class="nav in" id="side-menu">
          <li class="sidebar-search">
            <div class="input-group custom-search-form">
              <input type="text" class="form-control" placeholder="Search..." />
              <span class="input-group-btn">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
            <!-- /input-group -->
          </li>
          <li>
            <router-link to="/dashboard" class="active"
              ><i class="fa fa-dashboard fa-fw"></i> Dashboard</router-link
            >
          </li>
          <li>
            <router-link to="/users" class=""
              ><i class="fa fa-users fa-fw"></i> User Mgmt </router-link
            >
          </li>
          <li>
            <router-link to="/booking" class=""
              ><i class="fa fa-ticket fa-fw"></i> Booking Mgmt</router-link
            >
          </li>
          <li>
            <router-link to="/smartbox-list" class=""
              ><i class="fa fa-ticket fa-fw"></i> Smartbox Mgmt</router-link
            >
          </li>
          <li class="sub_menu ">
            <a href="#"
              ><i class="fa fa-gear fa-fw"></i> Settings<span
                class="fa arrow"
              ></span
            ></a>
            <ul class="nav nav-second-level collapse">
              <li>
                <router-link to="/country" class="active"
                  ><i class="fa fa-flag fa-fw"></i> Country</router-link
                >
              </li>
              <li>
                <router-link to="/state" class="active"
                  ><i class="fa fa-sitemap fa-fw"></i> State/County</router-link
                >
              </li>
              <li>
                <router-link to="/city" class="active"
                  ><i class="fa fa-sitemap fa-fw"></i> City/Region</router-link
                >
              </li>
            </ul>
            <!-- /.nav-second-level -->
          </li>
            <li class="sub_menu ">
            <a href="#"
              ><i class="fa fa-book fa-fw"></i>Web Pages<span
                class="fa arrow"
              ></span
            ></a>
            <ul class="nav nav-second-level collapse">
              <li>
                <router-link to="/page-type" class=""
                  ><i class="fa fa-file-archive-o fa-fw"></i> Page Type</router-link
                >
              </li>
              <li>
                <router-link to="/pages" class=""
                  ><i class="fa fa-file   fa-fw"></i> Pages</router-link
                >
              </li>
             
            </ul>
            <!-- /.nav-second-level -->
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import axios from "axios";
export default {
  name: "Nav",
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