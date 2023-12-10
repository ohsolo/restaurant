<template>
  <form action="" autocomplete="off" @submit.prevent="handleForm" class="mb-4">
    <div class="row">
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("storeBranche.label1") }}</label>
          <input type="text" value="Brazil" disabled class="form-control" v-if="env_type == 'production'" />
          <SearchContent url="get-countries?search=" objKey="countries" focus myKey="nicename" :key="compKeys.key1"
            @my-call-back="countryCallBack" v-if="env_type == 'development'" />
        </div>
      </div>
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for="" class="mb-2">{{ $t("storeBranche.label2") }}</label>
          <SearchContent :url="
            'admin/get-regions-by-name?country_id=' +
            formData.country_id +
            '&search='
          " objKey="regions" focus myKey="title" @my-call-back="regionCallBack" :key="compKeys.key2" :style="[
            !formData.country_id ? 'pointer-events:none;opacity:0.5' : '',
          ]" />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for="" class="mb-2">{{ $t("storeBranche.label3") }}</label>
          <SearchContent :url="'get-cities?country_code=' + cityISO + '&address_key='" objKey="cities" focus
            myKey="name" @my-call-back="cityCallBack" :style="[
              !formData.region_id ? 'pointer-events:none;opacity:0.5' : '',
            ]" :key="compKeys.key3" />
        </div>
      </div>
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for="" class="mb-2">{{ $t("storeBranche.label4") }}</label>
          <SearchContent :url="
            'get-locations?country_code=' +
            cityISO +
            '&place_id=' +
            formData.city_id +
            '&address_key='
          " objKey="locations" focus myKey="name" @my-call-back="neiCallBack" :style="[
            !formData.city_id ? 'pointer-events:none;opacity:0.5' : '',
          ]" :key="compKeys.key4" />
        </div>
      </div>
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for=""> {{ $t("storeBranche.label5") }} </label>
          <input type="text" v-model="formData.value" required class="mt-2 form-control" />
        </div>
      </div>
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for=""> {{ $t("storeBranche.label3") }} </label>
          <input type="text" v-model="formData.phone" required class="mt-2 form-control" />
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12 text-end">
        <button type="submit" :disabled="!formData.neighbourhood_id || !formData.value" class="
            border-0
            bg_primary
            focus_primary
            text-light
            hover_light
            px-5
            py-2
            rounded
            me-2
          " :style="
            !formData.neighbourhood_id || !formData.value || !formData.phone
              ? 'cursor: not-allowed;'
              : ''
          ">
          {{ $t("addBtn") }}
        </button>
      </div>
    </div>
  </form>
</template>

<script>
import { API } from "../../../axois";
import SearchContent from "../../../components/admin-components/search-content/index.vue";

export default {
  name: "AddBranchForm",
  components: { SearchContent },
  data() {
    return {
      compKeys: {
        key1: 0,
        key2: 0,
        key3: 0,
        key4: 0,
      },
      cityISO: "",
      formData: {
        country_id: "",
        region_id: "",
        city_id: "",
        city_name: "",
        neighbourhood_id: "",
        location: "",
        value: "",
        phone: "",
      },
      env_type: null,
    };
  },
  created() {
    this.env_type = import.meta.env.VITE_ENV_TYPE;
    if (this.env_type == "production") {
      this.formData.country_id = "30";
      this.cityISO = "BR";
    }
  },
  methods: {
    // Submitting Form
    handleForm() {
      this.$store.commit("loaderShow");
      let ID = JSON.parse(localStorage.getItem("USER_INFO"));
      API(this, "admin/branch/" + ID.rest_id, "post", this.formData)
        .then((response) => {
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
          this.$emit("my-call-back");
        })
        .catch((err) => {
          this.$store.commit("loaderHide");
          console.error(
            "🚀 ~ file: store-branches.vue ~ handleForm ~ err",
            err
          );
        });
    },
    countryCallBack(item) {
      if (!this.formData.country_id || !item) {
        this.compKeys.key2 += 1;
        this.compKeys.key3 += 1;
        this.compKeys.key4 += 1;
        this.formData.country_id = "";
        this.cityISO = "";
        this.formData.region_id = "";
        this.formData.city_id = "";
        this.formData.neighbourhood_id = "";
      }
      this.formData.country_id = item.id;
      this.cityISO = item.iso;
    },
    // For Regions
    regionCallBack(item) {
      if (this.formData.region_id == "" || item == "") {
        this.compKeys.key3 += 1;
        this.compKeys.key4 += 1;
        this.formData.region_id = "";
        this.formData.city_id = "";
        this.formData.neighbourhood_id = "";
      }
      this.formData.region_id = item.region_id;
    },
    // For Cities
    cityCallBack(item) {
      if (this.formData.city_id !== "" || item == "") {
        this.compKeys.key4 += 1;
        this.formData.city_id = "";
        this.formData.neighbourhood_id = "";
      }
      this.formData.city_id = item.place_id;
      this.formData.city_name = item.name;
    },
    // for Neibhourhood
    neiCallBack(item) {
      this.formData.neighbourhood_id = item.place_id;
      this.formData.location = item.name;
    },
  },
};
</script>

<style>

</style>