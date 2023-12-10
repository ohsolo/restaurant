<template>
  <router-view />
  <div class="az_my_toast text-end">
    <LoginFailed v-if="this.$store.state.toast.loginFailToast" />
    <LoginFailToastArray v-if="this.$store.state.toast.loginFailToastArray" />
    <SuccessToast v-if="this.$store.state.toast.successToast" />
    <WarningToast v-if="this.$store.state.toast.warningToast" />
    <FailToast v-if="this.$store.state.toast.failToast" />
  </div>
</template>

<script>
import LoginFailed from "./components/admin-components/toast/loginFail.vue";
import LoginFailToastArray from "./components/admin-components/toast/loginFailArray.vue";
import SuccessToast from "./components/admin-components/toast/succesToast.vue";
import WarningToast from "./components/admin-components/toast/warningToast.vue";
import FailToast from "./components/admin-components/toast/failToast.vue";
export default {
  name: "App",
  components: {
    LoginFailed,
    LoginFailToastArray,
    SuccessToast,
    WarningToast,
    FailToast,
  },
};
</script>
