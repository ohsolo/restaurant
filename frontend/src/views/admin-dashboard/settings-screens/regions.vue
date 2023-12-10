<template>
  <section class="settings_screens">
    <div class="container-fluid">
      <div class="row mt-4">
        <div class="col-6">
          <h4 class="sec_hd t_primary fw-bold mb-4">
            {{ $t("setRg.hd1") }}
          </h4>
        </div>
        <div class="col-6 text-end">
          <button type="button" class="btn-success border-0 rounded px-3 py-2" @click="addRegion()" v-if="!formCheck">
            <fa icon="plus" /><span class="ms-2">{{ $t("addBtn") }}</span>
          </button>
        </div>
      </div>
      <form action="" class="az_globalForm" @submit.prevent="handleFrom" v-if="formCheck" autocomplete="off">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
            <div class="input_wrapper">
              <label for="">{{ $t("setRg.label1")
              }}<span class="text-danger">*</span></label>
              <input type="text" value="Brazil" disabled class="form-control" v-if="env_type == 'production'" />
              <SearchContent url="get-countries?search=" class="mt-2" :givenValue="countryName" objKey="countries" focus
                myKey="nicename" @my-call-back="myCallBack" v-if="env_type == 'development'" />
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
            <div class="input_wrapper">
              <label for="">{{ $t("setRg.label2")
              }}<span class="text-danger">*</span></label>
              <input type="text" required class="form-control mt-2" v-model="form.region" />
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
            <div class="input_wrapper">
              <label for="">{{ $t("setRg.label3") }}</label>
              <div class="mt-3">
                <label for="rdBtn1">
                  <input type="radio" name="for-region" value="active" id="rdBtn1" :checked="rdbtn"
                    class="form-check-input me-2" @change="handleRadio" />{{ $t("setRg.rd1") }}
                </label>
                <label for="rdBtn2" class="ms-3">
                  <input type="radio" name="for-region" value="disable" id="rdBtn2" :checked="!rdbtn"
                    class="me-2 form-check-input" @change="handleRadio" />{{ $t("setRg.rd2") }}
                </label>
              </div>
            </div>
          </div>
          <div class="col-12 mt-4">
            <div class="btn_wrapper mb-4">
              <button type="button" @click="() => (formCheck = false)"
                class="border-0 btn-secondary px-2 py-1 rounded me-2">
                {{ $t("cancelBtn") }}
              </button>
              <button type="submit" class="
                  border-0
                  bg_primary
                  focus_primary
                  text-light
                  hover_light
                  px-2
                  py-1
                  rounded
                  me-2
                " :style="
                  !form.country || !form.region ? 'cursor: not-allowed;' : ''
                " :disabled="!form.country || !form.region">
                {{ $t("addBtn") }}
              </button>
            </div>
          </div>
        </div>
      </form>
      <div class="row pb-5">
        <div class="col">
          <div class="table-responsive">
            <table class="table table-hover" style="min-width: 500px">
              <thead>
                <tr>
                  <th class="pt-3 bg-dark">
                    <h5 class="p_0 ps-5 text-start text-light">
                      {{ $t("setRg.th1") }}
                    </h5>
                  </th>
                  <th class="bg-dark">
                    <h5 class="p_0 text-center text-light">
                      {{ $t("setRg.th2") }}
                    </h5>
                  </th>
                  <th class="bg-dark">
                    <h5 class="p_0 text-center text-light">
                      {{ $t("setRg.th3") }}
                    </h5>
                  </th>
                  <th class="bg-dark">
                    <h5 class="p_0 text-center text-light">
                      {{ $t("setRg.th4") }}
                    </h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="3" align="center" v-if="records.data == ''">
                    <span>Data Not Found</span>
                  </td>
                </tr>
                <tr v-for="data in records" :key="data">
                  <td valign="middle" align="cetner">
                    <p class="m_0 text-start ps-5">
                      {{ data.country_detail?.nicename }}
                    </p>
                  </td>
                  <td valign="middle" align="cetner">
                    <p class="m_0 text-center">{{ data.title }}</p>
                  </td>
                  <td valign="middle" align="center">
                    <button type="button" disabled class="border-0 rounded px-2 py-1" v-if="data.active">
                      <fa icon="check" class="text-success" />
                    </button>
                    <button type="button" disabled v-if="!data.active" class="border-0 rounded px-2 py-1">
                      <fa icon="ban" class="text-danger" />
                    </button>
                  </td>
                  <td valign="middle" align="center">
                    <button type="button" class="btn-primary border-0 rounded px-2 py-1 me-2"
                      @click="editQuestion(data)">
                      <fa icon="pen" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="myPagination28 mt-4">
            <pagination v-model="page" :records="records?.total * 1" :per-page="records?.per_page"
              @paginate="paginationCallback($event)" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { API } from "../../../axois";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import SearchContent from "../../../components/admin-components/search-content/index.vue";

export default {
  name: "Regions",
  title: "Regions | Dashboard",
  components: { SearchContent },
  data() {
    return {
      formCheck: false,
      page: 1,
      records: [],
      flag: false,
      rdbtn: true,
      countryName: "",
      form: {
        id: null,
        country: "",
        region: "",
        status: "",
      },
      env_type: null,
    };
  },
  created() {
    this.getRecords();
    this.env_type = import.meta.env.VITE_ENV_TYPE;
    if (this.env_type == "production") {
      this.form.country = "30";
      this.form.countryName = "Brazil";
    }
  },
  methods: {
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
    getRecords() {
      const fd = new FormData();
      fd.append("page", this.page);
      this.$store.commit("loaderShow");
      API(this, "admin/all-regions", "get", null)
        .then((response) => {
          this.records = response.data.response.detail;
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: regions.vue ~ getRecords ~ err",
            err
          );
          this.$store.commit("loaderHide");
        });
    },
    editQuestion(data) {
      this.countryName = data.country_detail.nicename;
      this.rdbtn = data.active;
      this.form.country = data.country_id;
      this.form.region = data.title;
      this.form.status = data.active ? "active" : "disable";
      this.form.id = data.region_id;
      this.formCheck = true;
      this.flag = false;
    },
    addRegion() {
      this.form.country = "";
      this.form.region = "";
      this.form.region = "";
      this.countryName = "";
      this.formCheck = true;
      this.flag = true;
    },
    handleRadio(v) {
      this.form.status = v.target.value;
      if (v.target.value == "active") {
      }
    },
    handleFrom() {
      this.$store.commit("loaderShow");
      let fd = new FormData();
      fd.append("country_id", this.form.country);
      fd.append("title", this.form.region);
      var apiCall;
      if (this.flag) {
        apiCall = "admin/region";
      } else {
        apiCall = "admin/update-region/" + this.form.id;
        fd.append("status", this.form.status);
      }
      API(this, apiCall, "post", fd)
        .then((response) => {
          this.form.country = "";
          this.form.region = "";
          this.form.id = null;
          this.getRecords();
          this.formCheck = false;
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((err) => {
          this.$store.commit("loaderHide");
          if (err.response.status == 422) {
            let msg = err.response.data.detail.title[0];
            this.$store.dispatch("WarningToast", {
              message: msg,
            });
          } else {
            this.$store.dispatch("WarningToast", {
              message: 'Something went wrong. Please try again.',
            });
          }
        });
    },
    myCallBack(item) {
      if (!item) {
        this.form.country = "";
      } else {
        this.form.country = item.id;
      }
    },
    deleteRequest(id) {
      return;
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
          console.error("🚀 ~ file: regions.vue ~ deleteRequest ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
  },
};
</script>

<style>

</style>
