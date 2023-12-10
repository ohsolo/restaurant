<template>
  <div class="admin_login_page">
    <div class="container">
      <div class="row">
        <div class="form_wrapper">
          <div class="form_left_col bg_primary">
            <div class="logo_wrapper">
              <img src="../../assets/images/logo.png" class="img-fluid" alt="" />
            </div>
            <div class="left_content">
              <h5>{{ $t("adminLog.welcome") }}</h5>
            </div>
          </div>
          <form role="form" @submit.prevent="handleSubmit" class="az_globalForm">
            <div class="row">
              <!-- <div class="col-12"> -->
              <h4 class="m_0 fw-bolds text-left">{{ $t("adminLog.hd1") }}</h4>
              <!-- </div> -->
            </div>
            <div class="row">
              <div class="col-12">
                <div class="input_wrapper login_input">
                  <label for="email" class="mb-2">{{
                  $t("adminLog.label1")
                  }}</label>
                  <input type="text" class="form-control ps-4" :placeholder="$t('adminLog.label1pl')" aria-label="email"
                    v-model="form.email" />
                  <small class="error" v-for="(error, index) of v$.form.email.$errors" :key="index">
                    {{ error.$message }}
                  </small>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12">
                <div class="input_wrapper">
                  <label for="Username" class="mb-2">{{
                  $t("adminLog.label2")
                  }}</label>
                  <input type="password" class="form-control ps-4" :placeholder="$t('adminLog.label2pl')"
                    aria-label="Password" v-model="form.password" />
                  <small class="error" v-for="(error, index) of v$.form.password.$errors" :key="index">
                    {{ error.$message }}
                  </small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mt-4">
                <!-- <small class="form_info_txt"
                  >By sign in, you agree to
                  <span class="t_primary fw-bold">Terms Of Service</span></small
                > -->
                <div class="d-flex w-100">
                  <input type="submit"
                    class="btn bg_primary hover_light text-light d-block mt-3 text-left focus_primary"
                    :value="$t('adminLog.logBtn')" style="width: 100%; max-width: 150px; font-weight: 600" />
                  <router-link to="/store-login"
                    class="btn resturant_btn bg_primary hover_light text-light d-block mt-3 text-left focus_primary w-50"
                    style="width: 100%; max-width: 150px; font-weight: 600">
                    {{$t('adminLog.btn2')}}
                  </router-link>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import { API } from "../../axois";
export default {
  name: "Login",
  title: "Login",
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
    };
  },
  validations() {
    return {
      form: {
        email: { required, email },
        password: { required },
      },
    };
  },
  mounted() { },
  methods: {
    handleSubmit() {
      this.v$.$touch();
      if (!this.v$.$error) {
        this.$store.commit("loaderShow");
        var fd = new FormData();
        fd.append("email", this.form.email);
        fd.append("password", this.form.password);
        API(this, "admin-login", "post", fd)
          .then((response) => {
            let Data = response.data.response.detail;

            localStorage.setItem("USER_INFO", JSON.stringify(Data.detail));
            localStorage.setItem("LOGIN_TYPE", JSON.stringify('ADMIN_DASHBOARD'));
            localStorage.setItem(
              "ACCESS_TOKEN",
              JSON.stringify(Data.token_detail.access_token)
            );

            this.$store.commit("loaderHide");
            this.$store.commit("setAdmin", Data);
            this.$store.commit("setToken", Data.token_detail.access_token);
            this.$store.dispatch("SuccessToast", {
              message: response.data.response.message,
            });
            this.$router.push("/");
          })
          .catch((error) => {
            console.error("🚀 ~ file: login.vue ~ handleSubmit ~ error", error)
            var msg = [];
            if (error.response.status == 422) {
              if (error.response.data.detail.email.length) {
                msg.push(error.response.data.detail.email[0]);
              }
              if (error.response.data.detail.password.length) {
                msg.push(error.response.data.detail.password[0]);
              }
              this.$store.dispatch("FailToast", {
                message: msg,
              });
            } else {
              msg.push(error.response.data.error.message);
              this.$store.dispatch("FailToast", {
                message: msg,
              });
            }
            this.$store.commit("loaderHide");
          });
      }
    },
  },
};
</script>

<style lang="scss" scoped>

</style>
