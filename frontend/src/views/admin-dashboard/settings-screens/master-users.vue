<template>
  <section class="settings_screens">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">
            {{ $t("muPg.main_title") }}
          </h4>
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-12">
          <button type="button" class="btn-success border-0 rounded px-3 py-2" @click="addUser()">
            <fa icon="plus" /><span class="ms-2">{{ $t("addBtn") }}</span>
          </button>
        </div>
      </div>
      <form action="" class="az_globalForm" @submit.prevent="handleFrom" v-if="formCheck">
        <div class="row">
          <div class="col-12">
            <div class="input_wrapper">
              <label for="">{{ $t("muPg.label1") }}</label>
              <input type="text" required name="name" class="form-control mt-2" v-model="form.name" />
              <small class="error" v-for="(error, index) of v$.form.name.$errors" :key="index">
                {{ error.$message }}
              </small>
            </div>
            <div class="input_wrapper mt-3">
              <label for="">{{ $t("muPg.label2") }}</label>
              <input type="email" required name="email" class="form-control mt-2" v-model="form.email"
                :disabled="flag == false" />
              <small class="error" v-for="(error, index) of v$.form.email.$errors" :key="index">
                {{ error.$message }}
              </small>
            </div>
            <div class="input_wrapper mt-3">
              <label for="">{{ $t("muPg.label3") }}</label>
              <input type="password" :required="!flag == false" name="password" class="form-control mt-2"
                v-model="form.password" />
              <small class="error" v-for="(error, index) of v$.form.password.$errors" :key="index">
                {{ error.$message }}
              </small>
            </div>
            <div class="btn_wrapper mt-4 mb-4">
              <button type="button" @click="() => (formCheck = false)"
                class="border-0 btn-secondary px-2 py-1 rounded me-2">
                {{ $t("cancelBtn") }}
              </button>
              <input type="submit" class="
                  border-0
                  bg_primary
                  focus_primary
                  text-light
                  hover_light
                  px-2
                  py-1
                  rounded
                  me-2
                " :value="$t('sendBtn')" />
            </div>
          </div>
        </div>
      </form>
      <div class="row pb-5">
        <div class="col">
          <div class="table-responsive">
            <table class="table table-hover" style="min-width: 600px">
              <thead>
                <tr>
                  <th class="pt-3" style="background-color: #333">
                    <h5 class="p_0 text-center text-light">
                      {{ $t("muPg.th1") }}
                    </h5>
                  </th>
                  <th style="background-color: #333">
                    <h5 class="p_0 text-center text-light">
                      {{ $t("muPg.th2") }}
                    </h5>
                  </th>
                  <th style="background-color: #333">
                    <h5 class="p_0 text-center text-light">
                      {{ $t("muPg.th3") }}
                    </h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="3" align="center" v-if="records.length == ''">
                    <span>{{ $t("muPg.notFound") }}</span>
                  </td>
                </tr>
                <tr v-for="data in records" :key="data">
                  <td valign="middle" align="center">
                    <p class="m_0">{{ data.name }}</p>
                  </td>
                  <td valign="middle" align="center">
                    <p class="m_0">{{ data.email }}</p>
                  </td>
                  <td valign="middle" align="center">
                    <button type="button" class="btn-primary border-0 rounded px-2 py-1 me-2" @click="editUser(data)">
                      <fa icon="pen" />
                    </button>
                    <button type="button" class="btn-danger border-0 rounded px-2 py-1"
                      @click="deleteRequest(data.admin_id)">
                      <fa icon="times-circle" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { API } from "../../../axois";
import useVuelidate from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
export default {
  name: "MasterUsers",
  title: "Master Users | Dashboard",
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      formCheck: false,
      records: [],
      flag: false,
      form: {
        id: null,
        name: "",
        email: "",
        password: "",
      },
    };
  },
  validations() {
    return {
      form: {
        name: { required },
        email: { required, email },
        password: this.flag == { required },
      },
    };
  },
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      API(this, "admin/get-admins", "get", null)
        .then((response) => {
          this.records = response.data.response.detail;
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          this.$store.commit("loaderHide");
        });
    },
    editUser(data) {
      this.form.name = data.name;
      this.form.email = data.email;
      this.form.id = data.admin_id;
      this.form.password = "";
      this.formCheck = true;
      this.flag = false;
    },
    addUser() {
      this.form.name = "";
      this.form.email = "";
      this.form.id = null;
      this.form.password = "";
      this.formCheck = true;
      this.flag = true;
    },
    handleFrom() {
      this.v$.$touch();
      if (!this.v$.$error) {
        this.$store.commit("loaderShow");
        let fd = new FormData();
        var apiCall;
        if (this.flag) {
          apiCall = "admin/store-admin";
          fd.append("name", this.form.name);
          fd.append("email", this.form.email);
          fd.append("password", this.form.password);
        } else {
          apiCall = "admin/update-admin";
          fd.append("admin_id", this.form.id);
          fd.append("name", this.form.name);
          fd.append("password", this.form.password);
        }
        this.form.name = "";
        this.form.email = "";
        this.form.id = null;
        this.form.password = "";
        this.formCheck = false;
        this.flag = true;
        API(this, apiCall, "post", fd)
          .then((response) => {
            this.getRecords();
            this.$store.commit("loaderHide");
            this.$store.dispatch("SuccessToast", {
              message: response.data.response.message,
            });

          })
          .catch((err) => {
            console.error("🚀 ~ file: master-users.vue ~ handleFrom ~ err", err)
            if (err.response.status == 422) {
              let msg = [];
              if (err.response.data.detail.email) {
                msg.push(err.response.data.detail.email[0]);
              }
              if (err.response.data.detail.name) {
                msg.push(err.response.data.detail.name[0]);
              }
              this.$store.commit("loaderHide");
              this.$store.dispatch("FailToast", {
                message: msg,
              });
            }
            this.$store.commit("loaderHide");
          });
      }
    },
    deleteRequest(id) {
      this.$store.commit("loaderShow");
      let fd = new FormData();
      fd.append("admin_id", id);
      API(this, "admin/delete-admin", "post", fd)
        .then((response) => {
          let newArr = this.records.filter((x) => x.admin_id !== id);
          this.records = newArr;
          this.$store.commit("loaderHide");
          let msg = [response.data.response.message];
          this.$store.dispatch("FailToast", {
            message: msg,
          });
        })
        .catch((err) => {
          console.error("🚀 ~ file: master-users.vue ~ deleteRequest ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
  },
};
</script>

<style>

</style>
