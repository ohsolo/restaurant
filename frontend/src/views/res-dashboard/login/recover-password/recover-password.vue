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
              <h4 class="m_0 fw-bolds text-left">Recover Password</h4>
              <!-- </div> -->
            </div>
            <div class="row">
              <div class="col-12">
                <div class="input_wrapper login_input">
                  <label for="password" class="mb-2">Enter New Password</label>
                  <input
                    type="text"
                    class="form-control ps-4"
                    placeholder="Enter new password"
                    aria-label="password"
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
                  value="Update"
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
  name: "RecoverPassword",
  title: "Recover-password",
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      form: {
        password: "",
      },
      availableToken: null,
    };
  },
  validations() {
    return {
      form: {
        password: { required },
      },
    };
  },
  created() {
    this.verifyToken();
  },
  computed() {},
  methods: {
    verifyToken() {
      this.availableToken = this.$route.params.token;
      this.$store.commit("loaderShow");
      var fd = new FormData();
      fd.append("token", this.availableToken);
      API(this, "rider-check-forget-password-token", "post", fd)
        .then((response) => {
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
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
          this.$router.push("/login");
        });
    },
    async handleSubmit() {
      this.v$.$touch();
      if (!this.v$.$error) {
          this.$store.commit("loaderShow");
          var fd = new FormData();
          fd.append("password", this.form.password);
          fd.append("token", this.availableToken);
          API(this, "update-rider-password", "post", fd)
            .then((response) => {
              this.$store.commit("loaderHide");
              this.$store.dispatch("SuccessToast", {
                message: response.data.response.message,
              });
              this.$router.push("/");
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
