<template>
  <header>
    <nav>
      <div class="d-flex align-items-center">
        <button type="button border-0" @click="openMenu" class="open_primary_nav">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </button>
        <h2 class="sm_d_none">{{ $t("dashboard") }}</h2>
      </div>

      <div class="user_container ms-auto">
        <!-- <div class="mx-1">
          <select v-model="$i18n.locale" class="form-select" @change="changeLanguage($event)">
            <option value="en">English</option>
            <option value="por">Portuguese</option>
          </select>
        </div> -->
        <div class="dropdown" v-if="user !== null">
          <button class="btn d-flex align-items-center dropdown-toggle" type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar">
              <fa icon="user" class="img-fluid" width="40" height="40" v-if="loginType=='ADMIN_DASHBOARD'" />
              <img :src="user.logo_url" alt="" class="img-fluid" width="40" height="40" v-else />
            </div>
            <div>
              <h5 class="m_0 mx-2 text-dark" v-if="loginType=='ADMIN_DASHBOARD'">{{user.name}}</h5>
              <h5 class="m_0 mx-2 text-dark" v-else>{{user.title}}</h5>
            </div>
          </button>
          <ul class="dropdown-menu p_relative" aria-labelledby="dropdownMenuButton1">
            <li>
              <router-link to="/admin-profile" class="dropdown-item" v-if="loginType=='ADMIN_DASHBOARD'">
                {{ $t("profile") }}
              </router-link>
              <router-link to="/profile" class="dropdown-item" v-else>
                {{ $t("profile") }}
              </router-link>
            </li>
            <li>
              <button class="dropdown-item border-0" @click="logOut" type="button">
                {{ $t("lgOut") }}
              </button>
            </li>
          </ul>
        </div>
        <div v-if="user == null">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
        <fa icon="bell" />
      </div>
    </nav>
  </header>
</template>

<script>
import { API } from "../../../axois.js";

export default {
  name: "Header",
  data() {
    return {
      user: null,
      loginType: null
    };
  },
  created() {
    this.loginType = JSON.parse(localStorage.getItem("LOGIN_TYPE"));
    this.user = this.$store.state.admin;
  },
  methods: {
    logOut() {
      this.$store.commit("loaderShow");
      let type = JSON.parse(localStorage.getItem("LOGIN_TYPE"));
      let url;
      if (type == "RES_DASHBOARD") {
        url = 'rest/rest-logout';
      } else {
        url = 'admin/admin-logout';
      }
      API('this', url, 'get').then(res => {
        localStorage.removeItem("ACCESS_TOKEN");
        this.$store.commit("logOut");
        this.$store.commit("loaderHide");
        this.$router.push("/login");
      }).catch(err => {
        console.error("🚀 ~ file: header.vue ~ API ~ err", err)
      })
    },
    openMenu() {
      this.$store.commit("togglePrimaryNav", true);
    },
    changeLanguage(obj) {
      localStorage.setItem("language", obj.target.value);
    },
  },
};
</script>

<style>

</style>
