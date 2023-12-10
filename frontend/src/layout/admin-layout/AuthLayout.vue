<template>
  <div class="az_layoutf200">
    <router-view></router-view>
    <Footer />
  </div>
  <Loader v-if="this.$store.state.loader" />
</template>
<script>
import {Footer} from '../../components/index';
import Loader from "../../components/loader.vue";
export default {
  name: "auth-layout",
  components: { Footer,Loader },
  data() {
    return {
      year: new Date().getFullYear(),
    };
  },
  created() {
    const TOKEN=localStorage.getItem("ACCESS_TOKEN");
    const TYPE=localStorage.getItem("LOGIN_TYPE");
    if (!!TOKEN) {
      if(JSON.parse(TYPE) =='ADMIN_DASHBOARD'){
        this.$router.push("/home");
      }
      if(JSON.parse(TYPE) =='RES_DASHBOARD'){
        this.$router.push("/resturant-dashboard");
      }
    }
  },
};
</script>
