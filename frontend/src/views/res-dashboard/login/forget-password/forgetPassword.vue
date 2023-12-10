<template>
  <div class="admin_login_page">
    <div class="container">
      <div class="row">
        <div class="form_wrapper">
          <div class="form_left_col bg_primary">
            <div class="logo_wrapper">
              <img
                src="../../../../assets/images/logo.png"
                class="img-fluid"
                alt=""
              />
            </div>
            <div class="left_content">
              <h5>Welcome to the Litoral app dashboard</h5>
            </div>
          </div>
          <form
            role="form"
            @submit.prevent="handleSubmit"
            class="az_globalForm"
          >
            <div class="row">
              <!-- <div class="col-12"> -->
              <h4 class="m_0 fw-bolds text-left">Forget Password</h4>
              <!-- </div> -->
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
            <div class="row">
              <div class="col-12 mt-2">
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
                  value="Find"
                  style="width: 100%; max-width: 150px; font-weight: 600"
                />
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
// import axios from "axios";
import { API } from "../../../../axois";
export default {
  name: "ForgetPassword",
  title: "forget-password",
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      form: {
        email: "",
      },
    };
  },
  validations() {
    return {
      form: {
        email: { required, email },
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
        API(this, "verify-rest-email", "post", fd)
          .then((response) => {
            this.$store.commit("loaderHide");
            // this.$store.commit("setAdmin", Data);
            // this.$store.commit("setToken", Data.token_detail.access_token);
            this.$store.dispatch("SuccessToast", {
              message: response.data.response.message,
            });
            // this.$router.push("/riders/awaiting-approval");
          })
          .catch((error) => {
            if (error.response.status == 401) {
                this.$store.dispatch("loginFailToastArray", {
                message: error.response.data.error.message,
              });
            } else {
                this.$store.dispatch("loginFailToast", {
                  message: error.response.data.error.message,
                });
            }
            this.$store.commit("loaderHide");
          });
      } else {
        alert("Please Enter A Valid Email.");
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>
