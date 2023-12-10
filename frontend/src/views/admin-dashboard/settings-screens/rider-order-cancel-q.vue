<template>
  <section class="settings_screens">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">
            {{ $t("ridOrdCanQues.main_title") }}
          </h4>
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-12 text-end">
          <button
            type="button"
            class="btn-success border-0 rounded px-3 py-2"
            @click="addQuestion()"
          >
            <fa icon="plus" /><span class="ms-2">{{ $t("addBtn") }}</span>
          </button>
        </div>
      </div>
      <form
        action=""
        class="az_globalForm"
        @submit.prevent="handleFrom"
        ref="QuestionForm"
        v-if="formCheck"
      >
        <div class="row justify-content-center">
          <div class="col-md-8 col-sm-12 mb-sm-0 mb-3">
            <div class="input_wrapper">
              <label for="">{{ $t("rtQuesPg.label1") }}</label>
              <input
                type="text"
                required
                class="form-control mt-2"
                v-model="form.question"
              />
            </div>
          </div>
          <div class="col-md-8 col-sm-12 mb-sm-0 mb-3 mt-4">
            <div class="d-flex">
              <div class="input_wrapper">
                <label for="btn1" class="me-2">For Rider</label>
                <input
                  type="radio"
                  required
                  name="q-type"
                  value="for_rider"
                  :checked="form.type=='for_rider'"
                  id="btn1"
                  class="form-check-input me-2"
                  @change="handleRdChange"
                  />
                </div>
              <div class="input_wrapper ms-4">
                <label for="btn2" class="me-2">For Restaurant</label>
                <input
                  type="radio"
                  required
                  name="q-type"
                  value="for_rest"
                  :checked="form.type=='for_rest'"
                  id="btn2"
                  class="form-check-input me-2"
                  @change="handleRdChange"
                />
              </div>
            </div>
            <div class="btn_wrapper mt-4 mb-4">
              <button
                type="button"
                @click="() => (formCheck = false)"
                class="border-0 btn-secondary px-2 py-1 rounded me-2"
              >
                {{ $t("cancelBtn") }}
              </button>
              <input
                type="submit"
                class="
                  border-0
                  bg_primary
                  focus_primary
                  text-light
                  hover_light
                  px-2
                  py-1
                  rounded
                  me-2
                "
                :value="$t('addBtn')"
              />
            </div>
          </div>
        </div>
      </form>
      <div class="row pb-5">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-hover" style="min-width: 500px">
              <thead>
                <tr>
                  <th class="pt-3 bg-dark">
                    <h5 class="p_0 text-start text-light">
                      {{ $t("rtQuesPg.th1") }}
                    </h5>
                  </th>
                  <th class="bg-dark">
                    <h5 class="p_0 text-center text-light">
                      {{ $t("rtQuesPg.th2") }}
                    </h5>
                  </th>
                  <th class="bg-dark">
                    <h5 class="p_0 text-center text-light">For</h5>
                  </th>
                  <th class="bg-dark">
                    <h5 class="p_0 text-end text-light">
                      {{ $t("rtQuesPg.th3") }}
                    </h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="3" align="center" v-if="records == ''">
                    <span>{{ $t("rtQuesPg.notFound") }}</span>
                  </td>
                </tr>
                <tr v-for="data in records" :key="data">
                  <td valign="middle" align="left">
                    <p class="m_0">{{ data.title }}</p>
                  </td>
                  <td valign="middle" align="center">
                    <div class="input_wrapper d-flex justify-content-center">
                      <div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                          :checked="data.active"
                          title="Update Status"
                          @change="
                            (e) =>
                              updateStatus(
                                e,
                                data.order_cancel_question_id,
                                data.title
                              )
                          "
                        />
                      </div>
                    </div>
                  </td>
                  <td valign="middle" align="center">
                    <p class="m_0">
                      {{ data.for_rider ? "Rider" : "Restaurant" }}
                    </p>
                  </td>
                  <td valign="middle" align="right">
                    <button
                      type="button"
                      class="btn-primary border-0 rounded px-2 py-1 me-2"
                      @click="editQuestion(data)"
                    >
                      <fa icon="pen" />
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
import { required } from "@vuelidate/validators";
export default {
  name: "RidOrdCanQuestion",
  title: "Rider Question | Dashboard",
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      formCheck: false,
      page: 1,
      records: [],
      flag: false,
      status: "not active",
      form: {
        id: null,
        question: "",
        type: "for_rider",
      },
      defaultState: {
        type: Boolean,
        default: false,
      },
    };
  },
  validations() {
    return {
      form: {
        question: { required },
      },
    };
  },
  created() {
    this.getRecords();
  },
  methods: {
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
    triggrToggle() {
      this.defaultState.default = !this.defaultState.default;
      if (this.defaultState.default) {
        this.status = "active";
      } else {
        this.status = "not active";
      }
    },
    getRecords() {
      this.$store.commit("loaderShow");
      API(this, "admin/get-order-cancel-questions", "get")
        .then((response) => {
          this.records = response.data.response.detail.cancel_questions;
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: rider-order-cancel-q.vue ~ getRecords ~ err",
            err
          );
          this.$store.commit("loaderHide");
        });
    },
    editQuestion(data) {
      this.form.question = data.title;
      this.form.id = data.order_cancel_question_id;
      this.form.type=data.for_rider?'for_rider':'for_rest';
      this.formCheck = true;
      this.flag = false;
    },
    addQuestion() {
      this.form.question = "";
      this.formCheck = true;
      this.flag = true;
    },
    handleFrom() {
      this.v$.$touch();
      if (!this.v$.$error) {
        this.$store.commit("loaderShow");
        let fd = new FormData();
        fd.append("title", this.form.question);
        fd.append("status", this.status);
        fd.append("key", this.form.type);
        var apiCall;
        if (this.flag) {
          apiCall = "admin/store-order-cancel-question";
        } else {
          apiCall = "admin/update-order-cancel-question";
          fd.append("id", this.form.id);
        }
        API(this, apiCall, "post", fd)
          .then((response) => {
            this.form.question = "";
            this.form.id = this.status = null;
            this.defaultState.default = false;
            // this.status = null;
            this.getRecords();
            this.formCheck = false;
            this.$store.commit("loaderHide");
            this.$store.dispatch("SuccessToast", {
              message: response.data.response.message,
            });
          })
          .catch((err) => {
            this.$store.commit("loaderHide");
            let msg = [err.response.data.response.message];
            this.$store.dispatch("FailToast", {
              message: msg,
            });
          });
      }
    },
    updateStatus(e, id, text) {
      this.$store.commit("loaderShow");
      let fd = new FormData();
      fd.append("id", id);
      let status = e.target.checked ? "active" : "disabled";
      fd.append("status", status);
      API(this, "admin/update-order-cancel-question", "post", fd)
        .then((res) => {
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: res.data.response.message,
          });
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: rider-order-cancel-q.vue ~ updateStatus ~ err",
            err
          );
          this.$store.commit("loaderHide");
        });
    },
    handleRdChange(e){
      let value=e.target.value;
      this.form.type=value;
    }
  },
};
</script>

<style>
</style>
