<template>
  <div class="admin_login_page">
    <div class="container">
      <div class="row">
        <div class="form_wrapper">
          <div class="form_left_col bg_primary">
            <div class="logo_wrapper">
              <img
                src="../../../assets/images/logo.png"
                class="img-fluid"
                alt=""
              />
            </div>
            <div class="left_content">
              <h5>{{ $t("adminLog.welcome")  }}</h5>
            </div>
          </div>
          <form
            role="form"
            @submit.prevent="handleSubmit"
            class="az_globalForm"
          >
            <div class="row">
              <h4 class="m_0 fw-bolds text-left">Login</h4>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="input_wrapper login_input">
                  <label for="email" class="mb-2">Email</label>
                  <input
                    type="text"
                    class="form-control ps-4"
                    placeholder="Enter your email"
                    aria-label="email"
                    v-model="form.email"
                  />
                  <small
                    class="error"
                    v-for="(error, index) of v$.form.email.$errors"
                    :key="index"
                  >
                    {{ error.$message }}
                  </small>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12">
                <div class="input_wrapper">
                  <label for="Username" class="mb-2">Password</label>
                  <input
                    type="password"
                    class="form-control ps-4"
                    placeholder="Enter your password"
                    aria-label="Password"
                    v-model="form.password"
                  />
                  <small
                    class="error"
                    v-for="(error, index) of v$.form.password.$errors"
                    :key="index"
                  >
                    {{ error.$message }}
                  </small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mt-4 d-flex">
                <input
                  type="submit"
                  class="
                    btn
                    bg_primary
                    hover_light
                    text-light
                    d-block
                    mt-3
                    text-left
                    focus_primary
                  "
                  :value="$t('adminLog.logBtn')"
                  style="width: 100%; max-width: 150px; font-weight: 600"
                />
                <router-link
                  to="/login"
                  class="
                    btn
                    resturant_btn
                    bg_primary
                    hover_light
                    text-light
                    d-block
                    mt-3
                    text-left
                    focus_primary
                    w-50
                  "
                  style="width: 100%; max-width: 150px; font-weight: 600"
                >
                  {{ $t("adminLog.btn3") }}
                </router-link>
              </div>
              <div class="col-12">
                <router-link to="/forget-password">
                  <small class="mt-3 d-inline-block">{{ $t("adminLog.forget_Password") }}</small>
                </router-link>
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
import { API } from "../../../axois";
export default {
  name: "StoreLogin",
  title: "Store Login",
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
  mounted() {},
  methods: {
    async handleSubmit() {
      this.v$.$touch();
      if (!this.v$.$error) {
        this.$store.commit("loaderShow");
        var fd = new FormData();
        fd.append("email", this.form.email);
        fd.append("password", this.form.password);
        API(this, "rest-login", "post", fd)
          .then((response) => {
            let Data = response.data.response.detail;
            localStorage.setItem("USER_INFO", JSON.stringify(Data.detail));
            localStorage.setItem("LOGIN_TYPE", JSON.stringify("RES_DASHBOARD"));
            localStorage.setItem(
              "ACCESS_TOKEN",
              JSON.stringify(Data.token_detail.access_token)
            );

            this.$store.commit("loaderHide");
            this.$store.commit("setToken", Data.token_detail.access_token);
            this.$store.dispatch("SuccessToast", {
              message: response.data.response.message,
            });
            this.$router.push("/resturant-dashboard");
          })
          .catch((error) => {
            if (error.response.status == 422) {
              this.$store.dispatch("loginFailToastArray", {
                message: error.response.data.detail,
              });
            } else {
              this.$store.dispatch("loginFailToast", {
                message: error.response.data.error.message,
              });
            }
            this.$store.commit("loaderHide");
          });
      } else {
        alert("Form Submition Failed.");
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>
