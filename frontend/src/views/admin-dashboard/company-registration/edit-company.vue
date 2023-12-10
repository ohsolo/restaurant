<template>
  <section class="restaurant_reg">
    <div class="container-fluid">
      <form
        role="form"
        @submit.prevent="handleSubmit"
        ref="formDATA"
        class="az_globalForm"
      >
        <div class="row mb-4">
          <div class="col-6">
            <div class="gloabl_form_head t_primary mb-3">
              <fa icon="shop" />
              <h5 class="fw-bold">{{ $t("comp_Reg.hd1") }}</h5>
            </div>
          </div>
          <div class="col-6 text-end">
            <router-link
              to="/store"
              class="
                border-0
                rounded
                px-4
                py-2
                text-light
                bg_primary
                focus_primary
              "
            >
              {{ $t('back') }}
            </router-link>
          </div>
          <div class="col-12 mt-3">
            <div class="d-flex align-items-center">
              <div class="form_img_wrapper">
                <div class="file_icon_wraperr">
                  <fa icon="camera" />
                  <small v-if="file != null" class="d-block">
                    {{ file[0].name }}
                  </small>
                </div>
                <input
                  type="file"
                  class="file_input"
                  @change="filePicker($event)"
                  accept="image/jpeg, image/png"
                />
              </div>
              <div class="img_wrapper ms-4">
                <img
                  :src="record?.logo_url"
                  width="75"
                  alt="company-logo.png"
                  class="img-fluid"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label1") }}</label>
              <div class="p_relative">
                <input type="text" class="form-control" v-model="form.title" />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.title.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label2") }}</label>
              <div class="p_relative">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.social_reason"
                />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.social_reason.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label3") }} </label>
              <div class="p_relative">
                <input type="text" class="form-control" v-model="form.cnpj" />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.cnpj.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label4") }}</label>
              <div class="p_relative">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.public_place"
                />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.public_place.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label5") }} </label>
              <div class="p_relative">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.neighbourhood"
                />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.neighbourhood.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label6") }} </label>
              <div class="p_relative">
                <input type="text" class="form-control" v-model="form.cep" />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.cep.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 d-flex align-items-center mt-4 mb-3">
            <h5 class="m_0">{{ $t("comp_Reg.hd2") }}</h5>
            <button
              @click="addField"
              class="btn focus_primary bg_primary text-light ms-4"
              type="button"
              :disabled="form.phones == ''"
            >
              {{ $t("addBtn") }}
            </button>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2 sr-only">phone</label>
              <div class="p_relative">
                <input type="text" class="form-control" v-model="form.phones" />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.phones.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div
            class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4"
            v-for="item in fields"
            :key="item.index"
          >
            <div class="d-flex align-items-center">
              <CustomInput
                label=""
                type="text"
                @custom-input-change="getData"
                :required="false"
                :value="item.value"
                :index="item.index"
                :hasError="false"
              />
              <span class="sr-only">{{ item.index }}</span>
              <button
                type="button"
                class="ms-2 t_primary border-0"
                @click="removeField(item.index)"
                style="background-color: transparent"
              >
                <fa icon="times-circle" />
              </button>
            </div>
          </div>
        </div>
        <!-- <div class="row mt-4 mb-4">
          <div class="col-12">
            <div class="gloabl_form_head t_primary">
              <fa icon="bank" />
              <h5 class="fw-bold">{{ $t("comp_Reg.hd3") }}</h5>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label7") }} </label>
              <div class="p_relative">
                <input type="text" class="form-control" v-model="form.bank" />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.bank.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label8") }}</label>
              <div class="p_relative">
                <input type="text" class="form-control" v-model="form.agency" />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.agency.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label9") }} </label>
              <div class="p_relative">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.agency_verification_code"
                />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.agency_verification_code
                    .$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label10") }}</label>
              <div class="p_relative">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.account"
                />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.account.$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label11") }}</label>
              <div class="p_relative">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.account_verification_code"
                />
                <small
                  class="error"
                  v-for="(error, index) of v$.form.account_verification_code
                    .$errors"
                  :key="index"
                >
                  {{ error.$message }}
                </small>
              </div>
            </div>
          </div>
        </div> -->
        <div class="row mt-4 mb-4">
          <div class="col-12">
            <div class="gloabl_form_head t_primary">
              <fa icon="lock" />
              <h5 class="fw-bold">{{ $t("comp_Reg.hd4") }}</h5>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label class="mb-2">{{ $t("comp_Reg.label12") }} </label>
              <div class="p_relative">
                <input
                  type="text"
                  class="form-control"
                  required
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
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label for="password" class="mb-2">{{
                $t("comp_Reg.label13")
              }}</label>
              <div class="p_relative">
                <input
                  type="password"
                  class="form-control"
                  v-model="form.password"
                />
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
            <div class="input_wrapper">
              <label for="confrim-password" class="mb-2"
                >{{ $t("comp_Reg.label14") }}
              </label>
              <div class="p_relative">
                <input
                  type="password"
                  class="form-control"
                  :required="form.password !== ''"
                  v-model="conformPass"
                />
                <small
                  class="error"
                  v-if="form.password !== conformPass && conformPass.length"
                >
                  Password does not match
                </small>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input
              type="submit"
              class="
                btn
                bg_primary
                focus_primary
                hover_light
                text-light
                d-block
                mt-5
                mx-auto
              "
              value="Save"
              style="width: 100%; max-width: 150px; font-weight: 600"
            />
          </div>
        </div>
      </form>
    </div>
  </section>
</template>
  
  <script>
import useVuelidate from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import CustomInput from "./customInput.vue";
import { API } from "../../../axois";
export default {
  name: "EditCompany",
  title: "Company Registration | Dashboard",

  components: {
    CustomInput,
  },

  setup() {
    return { v$: useVuelidate() };
  },

  data() {
    return {
      record: "",
      index: 0,
      fields: [],
      phoneArr: [],
      file: null,
      form: {
        logo: null,
        title: "",
        social_reason: "",
        cnpj: "",
        public_place: "",
        neighbourhood: "",
        cep: "",
        bank: "",
        phones: "",
        agency: "",
        agency_verification_code: "",
        account: "",
        account_verification_code: "",
        email: "",
        password: "",
      },
      conformPass: "",
    };
  },
  validations() {
    return {
      form: {
        title: { required },
        social_reason: { required },
        cnpj: { required },
        public_place: { required },
        neighbourhood: { required },
        cep: { required },
        phones: { required },
        // bank: { required },
        // agency: { required },
        // agency_verification_code: { required },
        // account: { required },
        // account_verification_code: { required },
        email: { required, email },
      },
    };
  },
  created() {
    this.getRecord();
  },
  methods: {
    getRecord() {
      this.$store.commit("loaderShow");
      API(this, `admin/get-restaurant/${this.$route.params.id}`, "get", null)
        .then((res) => {
          this.record = res?.data?.response?.detail;
          this.setFormData(res?.data?.response?.detail);
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: edit-company.vue ~ getRecord ~ err", err);
          this.$store.commit("loaderHide");
        });
    },
    setFormData(data) {
      if (!!data?.phones) {
        data?.phones.forEach((v, i) => {
          if (i == 0) {
            return 
          }else{
            this.getData(v, i);
            this.index++;
            this.fields.push({ index: this.index, value: v });
          }
        });
      }
      this.form = {
        logo: null,
        title: data?.title ?? "",
        social_reason: data?.social_reason ?? "",
        cnpj: data?.cnpj ?? "",
        public_place: data?.public_place ?? "",
        neighbourhood: data?.neighbourhood ?? "",
        cep: data?.cep ?? "",
        bank: data?.bank ?? "",
        phones: data?.phones[0] ?? "",
        agency: data?.agency ?? "",
        agency_verification_code: data?.agency_verification_code ?? "",
        account: data?.account ?? "",
        account_verification_code: data?.account_verification_code ?? "",
        email: data?.email ?? "",
        password: "",
      };
    },
    handleSubmit() {
      this.v$.$touch();
      if (!this.v$.$error) {
        this.$store.commit("loaderShow");
        // Form Data
        var fd = new FormData();
        Object.entries(this.form).forEach(([key, value]) => {
          if (key == "phones" || key == "logo" || value == "") {
            return;
          } else {
            fd.append(key, value);
          }
        });
        if (!!this.form.logo) {
          fd.append("logo", this.form.logo);
        }
        if (this.phoneArr.length) {
          this.phoneArr.map((i) => {
            fd.append("phones[]", i.value);
          });
        }
        fd.append("phones[]", this.form.phones);
        // API Call
        API(this, `admin/restaurant/${this.$route.params.id}`, "post", fd)
          .then((response) => {
            this.$store.commit("loaderHide");
            this.$store.dispatch("SuccessToast", {
              message: response.data.response.message,
            });
            this.$router.push("/store");
          })
          .catch((err) => {
            console.error("🚀 ~ file: index.vue ~ handleSubmit ~ err", err);
            this.$store.commit("loaderHide");
            let msg = err.response.data.detail.email;
            this.$store.dispatch("FailToast", {
              message: msg,
            });
          });
      } else {
        this.$store.commit("loaderHide");
        alert("Form submition failed ");
      }
    },
    addField() {
      this.index++;
      this.fields.push({ index: this.index });
    },
    removeField(i) {
      if (this.fields.length === 1) {
        this.fields = [];
      } else {
        let newField = this.fields.filter((x) => x.index != i);
        this.fields = newField;
        let newPhoneArr = this.phoneArr.filter((x) => x.index !== i);
        this.phoneArr = newPhoneArr;
      }
    },
    getData(e, i) {
      if (this.phoneArr.length == 0) {
        this.phoneArr.push({
          value: e,
          index: i,
        });
        return;
      }
      let objIndex = this.phoneArr.findIndex((obj) => obj.index == i);
      if (objIndex != -1) {
        this.phoneArr[objIndex].value = e;
      } else {
        this.phoneArr.push({
          value: e,
          index: i,
        });
      }
    },
    filePicker(event) {
      this.file = event.target.files;
      if (!this.file.length) return;
      this.form.logo = this.file[0];
    },
  },
};
</script>