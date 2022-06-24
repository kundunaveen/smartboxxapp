<template>
  <fragment>
    <nav class="navbar navbar-default navbar-static-top m-b-0">
      <div class="navbar-header">
        <a
          class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg"
          href="javascript:void(0)"
          data-toggle="collapse"
          data-target=".navbar-collapse"
        >
          <i class="fa fa-bars"></i>
        </a>
        <div class="top-left-part">
          <a class="logo" href="#">
            <b>
              <img
                v-bind:src="'../plugins/images/logo.png'"
                alt="home"
              />
            </b>
            <span>
              <img
                v-bind:src="'../plugins/images/logo-text.png'"
                alt="homepage"
                class="dark-logo"
              />
            </span>
          </a>
        </div>
        <ul class="nav navbar-top-links navbar-left hidden-xs">
          <li>
            <a
              href="javascript:void(0)"
              class="sidebartoggler font-20 waves-effect waves-light"
              ><i class="icon-arrow-left-circle"></i
            ></a>
          </li>
          <li>
            <form role="search" class="app-search hidden-xs">
              <i class="icon-magnifier"></i>
              <input type="text" placeholder="Search..." class="form-control" />
            </form>
          </li>
        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">
          <li class="dropdown">
            <a
              class="dropdown-toggle waves-effect waves-light font-20"
              data-toggle="dropdown"
              href="javascript:void(0);"
            >
              <i class="icon-speech"></i>
              <span class="badge badge-xs badge-danger">6</span>
            </a>
            <ul class="dropdown-menu mailbox animated bounceInDown">
              <li>
                <div class="drop-title">You have 4 new messages</div>
              </li>
              <li>
                <div class="message-center">
                  <a href="javascript:void(0);">
                    <div class="user-img">
                      <img
                        v-bind:src="'http://65.2.143.196/anadev/smartboxxapp/front-end/dist/plugins/images/users/1.jpg'"
                        alt="user"
                        class="img-circle"
                      />
                      <span class="profile-status online pull-right"></span>
                    </div>
                    <div class="mail-contnet">
                      <h5>Pavan kumar</h5>
                      <span class="mail-desc">Just see the my admin!</span>
                      <span class="time">9:30 AM</span>
                    </div>
                  </a>
                  <a href="javascript:void(0);">
                    <div class="user-img">
                      <img
                        v-bind:src="'http://65.2.143.196/anadev/smartboxxapp/front-end/dist/plugins/images/users/2.jpg'"
                        alt="user"
                        class="img-circle"
                      />

                      <span class="profile-status busy pull-right"></span>
                    </div>
                    <div class="mail-contnet">
                      <h5>Sonu Nigam</h5>
                      <span class="mail-desc"
                        >I've sung a song! See you at</span
                      >
                      <span class="time">9:10 AM</span>
                    </div>
                  </a>
                  <a href="javascript:void(0);">
                    <div class="user-img">
                      <img
                        v-bind:src="'/http://65.2.143.196/anadev/smartboxxapp/front-end/dist/plugins/images/users/3.jpg'"
                        alt="user"
                        class="img-circle"
                      />
                      <span class="profile-status away pull-right"></span>
                    </div>
                    <div class="mail-contnet">
                      <h5>Arijit Sinh</h5>
                      <span class="mail-desc">I am a singer!</span>
                      <span class="time">9:08 AM</span>
                    </div>
                  </a>
                  <a href="javascript:void(0);">
                    <div class="user-img">
                      <img
                        v-bind:src="'http://65.2.143.196/anadev/smartboxxapp/front-end/dist/plugins/images/users/4.jpg'"
                        alt="user"
                        class="img-circle"
                      />
                      <span class="profile-status offline pull-right"></span>
                    </div>
                    <div class="mail-contnet">
                      <h5>Pavan kumar</h5>
                      <span class="mail-desc">Just see the my admin!</span>
                      <span class="time">9:02 AM</span>
                    </div>
                  </a>
                </div>
              </li>
              <li>
                <a class="text-center" href="javascript:void(0);">
                  <strong>See all notifications</strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
            </ul>
          </li>
          <li class="dropdown">
            <a
              class="dropdown-toggle waves-effect waves-light font-20"
              data-toggle="dropdown"
              href="javascript:void(0);"
            >
              <i class="icon-calender"></i>
              <span class="badge badge-xs badge-danger">3</span>
            </a>
            <ul class="dropdown-menu dropdown-tasks animated slideInUp">
              <li>
                <a href="javascript:void(0);">
                  <div>
                    <p>
                      <strong>Task 1</strong>
                      <span class="pull-right text-muted">40% Complete</span>
                    </p>
                    <div class="progress progress-striped active">
                      <div
                        class="progress-bar progress-bar-success"
                        role="progressbar"
                        aria-valuenow="40"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        style="width: 40%"
                      >
                        <span class="sr-only">40% Complete (success)</span>
                      </div>
                    </div>
                  </div>
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="javascript:void(0);">
                  <div>
                    <p>
                      <strong>Task 2</strong>
                      <span class="pull-right text-muted">20% Complete</span>
                    </p>
                    <div class="progress progress-striped active">
                      <div
                        class="progress-bar progress-bar-info"
                        role="progressbar"
                        aria-valuenow="20"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        style="width: 20%"
                      >
                        <span class="sr-only">20% Complete</span>
                      </div>
                    </div>
                  </div>
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="javascript:void(0);">
                  <div>
                    <p>
                      <strong>Task 3</strong>
                      <span class="pull-right text-muted">60% Complete</span>
                    </p>
                    <div class="progress progress-striped active">
                      <div
                        class="progress-bar progress-bar-warning"
                        role="progressbar"
                        aria-valuenow="60"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        style="width: 60%"
                      >
                        <span class="sr-only">60% Complete (warning)</span>
                      </div>
                    </div>
                  </div>
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="javascript:void(0);">
                  <div>
                    <p>
                      <strong>Task 4</strong>
                      <span class="pull-right text-muted">80% Complete</span>
                    </p>
                    <div class="progress progress-striped active">
                      <div
                        class="progress-bar progress-bar-danger"
                        role="progressbar"
                        aria-valuenow="80"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        style="width: 80%"
                      >
                        <span class="sr-only">80% Complete (danger)</span>
                      </div>
                    </div>
                  </div>
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a class="text-center" href="javascript:void(0);">
                  <strong>See All Tasks</strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
            </ul>
          </li>
          <li class="right-side-toggle">
            <a
              class="right-side-toggler waves-effect waves-light b-r-0 font-20"
              href="javascript:void(0)"
            >
              <i class="icon-settings"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <aside class="sidebar">
      <div class="scroll-sidebar">
        <div class="user-profile">
          <div class="dropdown user-pro-body">
            <div class="profile-image">
              <img
                v-bind:src="'http://65.2.143.196/anadev/smartboxxapp/front-end/dist/plugins/images/users/hanna.jpg'"
                alt="user-img"
                class="img-circle"
              />
              <a
                href="javascript:void(0);"
                class="dropdown-toggle u-dropdown text-blue"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <span class="badge badge-danger">
                  <i class="fa fa-angle-down"></i>
                </span>
              </a>
              <ul class="dropdown-menu animated flipInY">
                <li>
                  <router-link to="/profile" class="active"
                    ><i class="fa fa-user"></i>Edit Profile</router-link
                  >
                </li>
                <li role="separator" class="divider"></li>
                <li>
                <li>
                  <router-link to="/change_pass" class="active"
                    ><i class="fa fa-key fa-fw"></i> Change
                    Password</router-link
                  >
                </li>
                <!-- <li>
                  <a href="javascript:void(0);"
                    ><i class="fa fa-inbox"></i> Inbox</a
                  >
                </li> -->
                <li role="separator" class="divider"></li>
                <li>
                  <a href="javascript:void(0);"
                    ><i class="fa fa-cog"></i> Account Settings</a
                  >
                </li>
                <li role="separator" class="divider"></li>
                <li>
                  <a href="javascript:void(0)" @click="handleClick"
                    ><i class="fa fa-power-off"></i> Logout</a
                  >
                </li>
              </ul>
            </div>
            <p class="profile-text m-t-15 font-16" v-if="user">
              <a href="javascript:void(0);">{{ user.name }}</a>
            </p>
          </div>
        </div>
        <nav class="sidebar-nav">
          <ul id="side-menu">
            <li>
              <router-link
                to="/dashboard"
                class="waves-effect"
                aria-expanded="false"
              >
                <i class="icon-screen-desktop fa-fw"></i>
                <span class="hide-menu"> Dashboard</span>

                <!-- <span class="label label-rounded label-info pull-right"
                  >3</span
                > -->
              </router-link>
              <!-- <ul aria-expanded="false" class="collapse">
              <li><a href="#">Modern Version</a></li>
              <li><a href="index2.html">Clean Version</a></li>
              <li><a href="index3.html">Analytical Version</a></li>
            </ul> -->
            </li>
            <li>
              <router-link
                to="/users"
                class="waves-effect"
                aria-expanded="false"
              >
                <i class="icon-user fa-fw"></i>
                <span class="hide-menu"> Users Mgmt </span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/booking"
                class="waves-effect"
                aria-expanded="false"
              >
                <i class="icon-calender fa-fw"></i>
                <span class="hide-menu"> Booking Mgmt </span>
              </router-link>
            </li>
            <li>
              <router-link
                to="/smartbox-list"
                class="waves-effect"
                aria-expanded="false"
              >
                <i class="icon-drawar fa-fw"></i>
                <span class="hide-menu"> SmartBoxx Mgmt </span>
              </router-link>
            </li>

            <li>
              <a
                class="waves-effect"
                href="javascript:void(0);"
                aria-expanded="false"
                ><i class="icon-notebook fa-fw"></i>
                <span class="hide-menu"> Settings </span></a
              >
              <ul aria-expanded="false" class="collapse">
                <li>
                  <router-link to="/country" class=""
                    ><i class="fa fa-flag fa-fw"></i> Country</router-link
                  >
                </li>
                <li>
                  <router-link to="/state" class=""
                    ><i class="fa fa-sitemap fa-fw"></i>
                    State/County</router-link
                  >
                </li>
                <li>
                  <router-link to="/city" class=""
                    ><i class="fa fa-sitemap fa-fw"></i>
                    City/Region</router-link
                  >
                </li>
              </ul>
            </li>
            <li>
              <a
                class="waves-effect"
                href="javascript:void(0);"
                aria-expanded="false"
                ><i class="icon-grid fa-fw"></i>
                <span class="hide-menu"> Web Pages</span></a
              >
              <ul aria-expanded="false" class="collapse">
                <li>
                  <router-link to="/pages" class=""
                    ><i class="fa fa-file fa-fw"></i> Pages</router-link
                  >
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <div class="p-30">
          <span class="hide-menu">
            <!-- <a
              href="javascript:void(0);"
              target="_blank"
              class="btn btn-success"
              >Buy Cubic Admin</a
            > -->
            <!-- <a
              href="javascript:void(0);"
              target="_blank"
              class="btn btn-default m-t-15"
              >Check Documentation</a
            > -->
          </span>
        </div>
      </div>
    </aside>
  </fragment>
</template>

<script>
import Vue from "vue";
import { Plugin } from "vue-fragment";
import axios from "axios";

Vue.use(Plugin);

export default {
  name: "Nav",
  components: {},
  beforeMount() {
    let recaptchaScript = document.createElement("script");
    recaptchaScript.setAttribute(
      "src",
      "http://65.2.143.196/anadev/smartboxxapp/front-end/dist/js/custom.js"
    );

    document.head.appendChild(recaptchaScript);
  },
  methods: {
    handleClick() {
      localStorage.removeItem("token");
      this.$router.push("/");
    },
  },
  data() {
    return {
      user: null,
      loading: false,
    };
  },
  async created() {
    this.loading = true;
    const response = await axios.get("/api/get_details");
    this.user = response.data.data;
    this.loading = false;
  },

  //   async created() {
  //   await axios
  //     .get("/api/get_details")
  //     .then((resp) => {
  //       this.user = resp.data.data;
  //     })
  //     .catch((err) => {
  //       console.log('err',err);
  //       this.$router.push("/");
  //     });
  // },
};
</script>

<style>
</style>