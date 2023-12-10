<template>
  <form action="" autocomplete="off" @submit.prevent="handleForm" class="mb-4">
    <div class="row">
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for="">{{ $t("storeBranche.label1") }}</label>
          <input
            type="text"
            value="Brazil"
            disabled
            class="mt-2 form-control"
          />
        </div>
      </div>
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for="" class="mb-2">{{ $t("storeBranche.label2") }}</label>
          <SearchContent
            :url="
              'admin/get-regions-by-name?country_id=' +
              formData.country_id +
              '&search='
            "
            objKey="regions"
            focus
            :style="[
              formData.country_id == ''
                ? 'pointer-events:none;opacity:0.5'
                : '',
            ]"
            myKey="title"
            @my-call-back="regionCallBack"
            :key="compKeys.key1"
          />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for="" class="mb-2">{{ $t("storeBranche.label3") }}</label>
          <SearchContent
            :url="'get-cities?country_code=' + cityISO + '&address_key='"
            objKey="cities"
            focus
            myKey="name"
            @my-call-back="cityCallBack"
            :style="[
              formData.region_id == '' ? 'pointer-events:none;opacity:0.5' : '',
            ]"
            :key="compKeys.key2"
          />
        </div>
      </div>
      <div class="col-6 mt-4">
        <div class="input_wrapper">
          <label for="" class="mb-2">{{ $t("storeBranche.label4") }}</label>
          <SearchContent
            :url="
              'get-locations?country_code=' +
              cityISO +
              '&place_id=' +
              formData.city_id +
              '&address_key='
            "
            objKey="locations"
            focus
            myKey="name"
            @my-call-back="neiCallBack"
            :style="[
              formData.city_id == '' ? 'pointer-events:none;opacity:0.5' : '',
            ]"
            :key="compKeys.key3"
          />
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-6 align-self-end">
        <button
          type="submit"
          :disabled="!formData.neighbourhood_id"
          class="
            border-0
            bg_primary
            focus_primary
            text-light
            hover_light
            px-5
            py-2
            rounded
            me-2
          "
          :style="!formData.neighbourhood_id ? 'cursor: not-allowed;' : ''"
        >
          {{ $t("addBtn") }}
        </button>
      </div>
    </div>
  </form>
</template>
  
  <script>
import { API } from "../../../axois.js";
import SearchContent from "../../../components/admin-components/search-content/index.vue";
export default {
  name: "AddAddress",
  components: { SearchContent },
  data() {
    return {
      compKeys: {
        key1: 0,
        key2: 0,
        key3: 0,
      },
      cityISO: "BR",
      formData: {
        country_id: "30",
        region_id: "",
        city_id: "",
        neighbourhood_id: "",
        location: "",
        value: "",
      },
    };
  },
  created() {},
  methods: {
    // Submitting Form
    handleForm() {
      this.$store.commit("loaderShow");
      API(this, "rest/address", "post", this.formData)
        .then((response) => {
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
          this.compKeys = {
            key1: this.compKeys.key1 + 1,
            key2: this.compKeys.key2 + 1,
            key3: this.compKeys.key3 + 1,
          };
        })
        .catch((err) => {
          this.$store.commit("loaderHide");
          console.error("🚀 ~ file: addresses.vue ~ handleForm ~ err", err);
        });
    },
    // For Regions
    regionCallBack(item) {
      if (this.formData.region_id == "" || item == "") {
        this.compKeys.key2 += 1;
        this.compKeys.key3 += 1;
        this.formData.region_id = "";
        this.formData.city_id = "";
        this.formData.neighbourhood_id = "";
      }
      this.formData.region_id = item.region_id;
    },
    // For Cities
    cityCallBack(item) {
      if (this.formData.city_id !== "" || item == "") {
        this.compKeys.key3 += 1;
        this.formData.city_id = "";
        this.formData.neighbourhood_id = "";
      }
      this.formData.city_id = item.place_id;
    },
    // for Neibhourhood
    neiCallBack(item) {
      this.formData.neighbourhood_id = item.place_id;
      this.formData.location = item.name;
      if (item == "") {
        this.formData.neighbourhood_id = "";
      }
    },
  },
};
</script>
  