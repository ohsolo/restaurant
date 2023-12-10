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
              <h4 class="m_0 fw-bolds text-left">Update Password</h4>
              <!-- </div> -->
            </div>
            <div class="row">
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
            <div class="row mt-4">
              <div class="col-12">
                <div class="input_wrapper">
                  <label for="Username" class="mb-2">Confirm Password</label>
                  <input
                    type="password"
                    class="form-control ps-4"
                    placeholder="Enter your password"
                    aria-label="Password"
                    v-model="form.confirmPassword"
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
              <div class="col-12 mt-2">
                <input
                  type="submit"
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
                  "
                  value="Update Password"
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
import { required } from "@vuelidate/validators";
import { useRoute } from "vue-router";
// import axios from "axios";
import { API } from "../../../../axois";
export default {
  name: "UpdatePassword",
  title: "Update-password",
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      form: {
        password: "",
        confirmPassword: "",
      },
      availableToken : null,
    };
  },
  validations() {
    return {
      form: {
        password: { required },
        confirmPassword: { required },
      },
    };
  },
  mounted() {},
  created() {
    const route = useRoute();
    this.availableToken = route.params.Token;
    this.verifyToken(this.availableToken);
  },
  methods: {
    verifyToken(token) {
      this.$store.commit("loaderShow");
      API(this, "check-forget-password-token", "post", { token: token })
        .then((response) => {
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$store.dispatch("FailToast", {
              message: error.response.data.detail,
            });
          } else {
            this.$store.dispatch("FailToast", {
              message: error.response.data.error.message,
            });
          }
          this.$store.commit("loaderHide");
          this.$router.push("/store-login");
        });
    },
    async handleSubmit() {
      this.v$.$touch();
      if (!this.v$.$error) {
        if (this.form.password == this.form.confirmPassword) {
          this.$store.commit("loaderShow");
          var fd = new FormData();
          fd.append("password", this.form.password);
          fd.append("token", this.availableToken);
          API(this, "update-password", "post", fd)
            .then((response) => {
              //   let Data = response.data.response.detail;
              this.$store.commit("loaderHide");
              this.$store.dispatch("SuccessToast", {
                message: response.data.response.message,
              });
                this.$router.push("/store-login");
            })
            .catch((error) => {
              if (error.response.status == 422) {
                this.$store.dispatch("FailToast", {
                  message: error.response.data.detail,
                });
              } else {
                this.$store.dispatch("FailToast", {
                  message: error.response.data.error.message,
                });
              }
              this.$store.commit("loaderHide");
            });
        } else {
          this.$store.dispatch("FailToast", {
            message: "Incorrect Password",
          });
        }
      } else {
        alert("Form Submition Failed.");
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>
