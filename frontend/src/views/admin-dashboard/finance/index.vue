<template>
  <section class="finance_page">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold">{{ $t("finances.hd1") }}</h4>
        </div>
      </div>
      <form action="" class="az_globalForm">
        <div class="row">
          <div class="col-2">
            <div class="input_wrapper">
              <select name="" id="" class="form-select">
                <option v-for="item in months" :key="{ item }">
                  {{ date(item) }}
                </option>
              </select>
            </div>
          </div>
          <div class="col-2">
            <div class="input_wrapper">
              <select name="" id="" class="form-select">
                <option>2021</option>
              </select>
            </div>
          </div>
        </div>
      </form>
      <div class="row mt-4">
        <div class="col-12">
          <div
            class="
              flex_wrapper
              d-flex
              justify-content-center
              align-items-stretch
            "
          >
            <CustomCard num="R$35,854.29" title="finances.cardSm1" />
            <CustomCard num="R$22,854.29" title="finances.cardSm2" />
            <CustomCard num="R$13,854.29" title="finances.cardSm3" />
          </div>
        </div>
      </div>
      <div class="row mt-5 mb-3">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold">{{ $t("finances.hd2") }}</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button
                class="nav-link active ms-1 mx-2"
                id="pills-transactions-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-transactions"
                type="button"
                role="tab"
                aria-controls="pills-transactions"
                aria-selected="true"
              >
                {{ $t("finances.btn1") }}
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link mx-2"
                id="pills-refills-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-refills"
                type="button"
                role="tab"
                aria-controls="pills-refills"
                aria-selected="false"
              >
                {{ $t("finances.btn2") }}
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link mx-2"
                id="pills-reviews-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-reviews"
                type="button"
                role="tab"
                aria-controls="pills-reviews"
                aria-selected="false"
              >
                {{ $t("finances.btn3") }}
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link mx-2"
                id="pills-balances-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-balances"
                type="button"
                role="tab"
                aria-controls="pills-balances"
                aria-selected="false"
              >
                {{ $t("finances.btn4") }}
              </button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div
              class="tab-pane fade show active"
              id="pills-transactions"
              role="tabpanel"
              aria-labelledby="pills-transactions-tab"
            >
              {{ $t("finances.btn1") }}
            </div>
            <div
              class="tab-pane fade"
              id="pills-refills"
              role="tabpanel"
              aria-labelledby="pills-refills-tab"
            >
              {{ $t("finances.btn2") }}
            </div>
            <div
              class="tab-pane fade"
              id="pills-reviews"
              role="tabpanel"
              aria-labelledby="pills-reviews-tab"
            >
              {{ $t("finances.btn3") }}
            </div>
            <div
              class="tab-pane fade"
              id="pills-balances"
              role="tabpanel"
              aria-labelledby="pills-balances-tab"
            >
              {{ $t("finances.btn4") }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import moment from "moment";
import CustomCard from "../reports/card.vue";
export default {
  name: "Finance",
  title: "Finance | Dashboard",
  components: { CustomCard },
  data() {
    return {
      months: [],
    };
  },
  created() {
    for (let i = 0; i < 12; i++) {
      this.months.push(moment().month("January").add(i, "months"));
    }
  },
  methods: {
    date(date) {
      return moment(date).format("MMMM");
    },
  },
};
</script>

<style lang="scss">
</style>
