<template>
  <div class="az_layoutf098">
    <!-- Navbar -->
    <Aside :items="items" @log_out="logOut" />
    <div
      class="az_main"
      :class="this.$store.getters.shrink ? 'side_menu_shrink' : null"
    >
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
import Loader from "../../components/loader.vue";
import { Aside, Header, Footer } from "../../components/index";
import { API } from "../../axois.js";

export default {
  components: { Loader, Aside, Header, Footer },
  name: "auth-layout",
  data() {
    return {
      loaderShow: false,
      year: new Date().getFullYear(),
      items: [
        {
          id: 555,
          url: "/",
          text: "home",
          icon: "home",
        },
        {
          id: 1,
          url: "/deliverer",
          text: "deli",
          icon: "shipping-fast",
          childrens: [
            {
              id: 11,
              url: "/riders/awaiting-approval",
              text: "awaitApp",
              icon: "store",
            },
            {
              id: 12,
              url: "/riders/active-deliveries",
              text: "actDeli",
              icon: "bank",
            },
            {
              id: 15,
              url: "/riders/blocked-deliveries",
              text: "blockDeli",
              icon: "store",
            },
            {
              id: 16,
              url: "/riders/occurrences",
              text: "occurr",
              icon: "store",
            },
            {
              id: 17,
              url: "/riders/ranking",
              text: "rank",
              icon: "star",
            },
          ],
        },
        {
          id: 2,
          url: "/store",
          text: "store",
          icon: "store-alt",
        },
        {
          id: 3,
          url: "/finance",
          text: "fin",
          icon: "dollar",
        },
        {
          id: 4,
          url: "/reports",
          text: "rep",
          icon: "chart-line",
        },
        {
          id: 5,
          url: "/#",
          text: "setting",
          icon: "cog",
          childrens: [
            {
              id: 51,
              url: "/settings/general-settings",
              text: "genSet",
              icon: "cog",
            },
            {
              id: 52,
              url: "/settings/values-by-distance",
              text: "valDis",
              icon: "dollar-sign",
            },
            {
              id: 53,
              url: "/settings/notification",
              text: "noti",
              icon: "bell",
            },
            {
              id: 54,
              url: "/settings/master-users",
              text: "mUser",
              icon: "users",
            },
            {
              id: 55,
              url: "/settings/rider-question",
              text: "ridfQ",
              icon: "question",
            },
            {
              id: 56,
              url: "/settings/resturant-question",
              text: "resfQ",
              icon: "question",
            },
            {
              id: 57,
              url: "/settings/order-cancel-question",
              text: "ridCanQ",
              icon: "question",
            },
            {
              id: 58,
              url: "/settings/regions",
              text: "reg",
              icon: "globe",
            },
            {
              id: 58,
              url: "/addresses",
              text: "addresses",
              icon: "globe",
            },
          ],
        },
      ],
    };
  },
  created() {
    let admin = JSON.parse(localStorage.getItem("USER_INFO"));
    this.$store.commit("setAdmin", admin);
  },
  methods: {
    logOut() {
      API("this", "admin/admin-logout", "get")
        .then((res) => {
          localStorage.removeItem("ACCESS_TOKEN");
          localStorage.removeItem("LOGIN_TYPE");
          localStorage.removeItem("USER_INFO");
          this.$store.commit("logOut");
          this.$router.push("/login");
        })
        .catch((err) => {
          console.error("🚀 ~ file: ResDashboard.vue ~ API ~ err", err);
        });
    },
  },
};
</script>
