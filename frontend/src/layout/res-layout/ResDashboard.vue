<template>
  <div class="az_layoutf098">
    <!-- Navbar -->
    <Aside :items="items" @log_out="logOut" />
    <div class="az_main" :class="this.$store.getters.shrink ? 'side_menu_shrink' : null">
      <!-- Header -->
      <Header />
      <!-- Page content -->
      <main class="az_body_content p_relative">
        <div class="az_page_content">
          <div>
            <router-view></router-view>
          </div>
          <Footer />
        </div>
      </main>
    </div>
  </div>
  <Loader v-if="this.$store.state.loader" />
</template>
<script>
import { API } from "../../axois.js";
import Loader from "../../components/loader.vue";
import { Aside, Header, Footer } from "../../components/index";
import axios from "axios";
export default {
  components: { Loader, Aside, Header, Footer },
  name: "res-layout",
  data() {
    return {
      loaderShow: false,
      year: new Date().getFullYear(),
      items: [
        {
          id: 1,
          url: "/resturant-dashboard",
          text: "home",
          icon: "home",
        },
        {
          id: 2,
          url: "/store-branches",
          text: "stBr",
          icon: "map-marker-alt",
        },
        {
          id: 3,
          url: "/resturant-finance",
          text: "fin",
          icon: "dollar",
        },
        {
          id: 4,
          url: "/view-addresses",
          text: "addresses",
          icon: "globe",
        },
        {
          id: 5,
          url: "/profile",
          text: "profile",
          icon: "user",
        },
      ],
    };
  },
  mounted() {
    API(this, "rest/check-token", "get", null)
      .then((res) => { })
      .catch((err) => {
        this.initFirebaseMessagingRegistration();
      });
  },
  created() {
    let admin = JSON.parse(localStorage.getItem("USER_INFO"));
    this.$store.commit("setAdmin", admin);
  },
  methods: {
    initFirebaseMessagingRegistration() {
      this.$Messaging
        .requestPermission()
        .then(() => {
          return this.$Messaging.getToken({
            vapidKey: this.$WebPC,
          });
        })
        .then(function (token) {
          API(this, "rest/save-pn-token", "post", { token: token })
            .then((res) => { })
            .catch((err) => { });
        })
        .catch(function (err) {
          console.error("🚀 ~ file: ResDashboard.vue ~ initFirebaseMessagingRegistration ~ err", err)
        });
    },
    logOut() {
      API("this", "rest/rest-logout", "get")
        .then((res) => {
          localStorage.removeItem("ACCESS_TOKEN");
          localStorage.removeItem("LOGIN_TYPE");
          localStorage.removeItem("USER_INFO");
          this.$store.commit("logOut");
          this.$router.push("/store-login");
        })
        .catch((err) => {
          console.error("🚀 ~ file: ResDashboard.vue ~ API ~ err", err);
        });
    },
  },
};
</script>
