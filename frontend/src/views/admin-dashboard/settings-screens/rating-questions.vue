<template>
  <section class="settings_screens">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">
            {{ $t("rtQuesPg.main_title") }}
          </h4>
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-12 text-end">
          <button type="button" class="btn-success border-0 rounded px-3 py-2" @click="addQuestion()">
            <fa icon="plus" /><span class="ms-2">{{ $t("addBtn") }}</span>
          </button>
        </div>
      </div>
      <form action="" class="az_globalForm" @submit.prevent="handleFrom" v-if="formCheck">
        <div class="row justify-content-center">
          <div class="col-md-8 col-sm-12">
            <div class="input_wrapper">
              <label for="">{{ $t("rtQuesPg.label1") }}</label>
              <input type="text" required question="question" class="form-control mt-2" v-model="form.question" />
            </div>
            <div class="btn_wrapper mt-4 mb-4">
              <button type="button" @click="() => (formCheck = false)"
                class="border-0 btn-secondary px-2 py-1 rounded me-2">
                {{ $t("cancelBtn") }}
              </button>
              <input type="submit"
                class="border-0 bg_primary focus_primary text-light hover_light px-2 py-1 rounded me-2"
                :value="$t('sendBtn')" />
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
                    <h5 class="p_0 text-end text-light">
                      Action
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
                    <p class="m_0">{{ data.text }}</p>
                  </td>
                  <td valign="middle" align="center">
                    <div class="input_wrapper d-flex justify-content-center">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                          :checked="data.active" title="Update Status"
                          @change="(e)=>updateStatus(e,data.rider_rating_question_id,data.text)" />
                      </div>
                    </div>
                  </td>
                  <td valign="middle" align="right">
                    <button type="button" class="btn-primary border-0 rounded px-2 py-1 me-2"
                      @click="editQuestion(data)" title="Edit Question">
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
  name: "RiderQuestion",
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
      form: {
        id: null,
        question: "",
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
    getRecords() {
      const fd = new FormData();
      fd.append("page", this.page);
      this.$store.commit("loaderShow");
      API(this, "admin/rider-rating-questions", "get", null)
        .then((response) => {
          this.records = response.data.response.detail;
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: rating-questions.vue ~ getRecords ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
    editQuestion(data) {
      this.form.question = data.text;
      this.form.id = data.rider_rating_question_id;
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
        fd.append("text", this.form.question);
        var apiCall;
        if (this.flag) {
          apiCall = "admin/rider-rating-question";
        } else {
          apiCall = "admin/update-rider-rating-question";
          fd.append("rider_rating_question_id", this.form.id);
        }
        API(this, apiCall, "post", fd)
          .then((response) => {
            this.form.question = "";
            this.form.id = null;
            this.formCheck = false;
            this.getRecords();
            this.$store.commit("loaderHide");
            this.$store.dispatch("SuccessToast", {
              message: response.data.response.message,
            });
          })
          .catch((err) => {
            console.error("🚀 ~ file: rating-questions.vue ~ handleFrom ~ err", err)
            this.$store.commit("loaderHide");
            let msg = [response.data.response.message];
            this.$store.dispatch("FailToast", {
              message: msg,
            });
          });
      }
    },
    updateStatus(e, id, text) {
      this.$store.commit("loaderShow");
      let fd = new FormData();
      fd.append("rider_rating_question_id", id);
      let status = e.target.checked ? 'active' : 'disabled';
      fd.append("status", status);
      API(this, "admin/update-rider-rating-question", "post", fd)
        .then((res) => {
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: res.data.response.message,
          });
        })
        .catch((err) => {
          console.error("🚀 ~ file: rating-questions.vue ~ updateStatus ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
  },
};
</script>

<style>

</style>
