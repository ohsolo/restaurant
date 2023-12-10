<template>
  <section class="reports_page">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold">Delivery Reports</h4>
        </div>
      </div>
      <form action="" autocomplete="off" class="az_globalForm">
        <div class="row mt-4">
          <div class="col-12">
            <div class="d-flex flex-wrap">
              <div class="input_wrapper d-flex mb-3">
                <label for="" class="me-3 w-50 align-items-center">
                  <span class="mb-2 d-block">{{
                    $t("asideRpt.calenTxt1")
                  }}</span>
                  <input type="date" class="form-control py-1" />
                </label>
                <label for="" class="w-50 align-items-center">
                  <span class="mb-2 d-block">{{
                    $t("asideRpt.calenTxt2")
                  }}</span>
                  <input type="date" class="form-control py-1" />
                </label>
              </div>
              <div
                class="input_wrapper mx-2"
                style="min-width: 150px; width: 100%; max-width: 200px"
              >
                <label for="" class="mb-2">{{ $t("asideRpt.label1") }}</label>
                <v-select :options="optionsStatus"></v-select>
              </div>
              <div
                class="input_wrapper mx-2"
                style="min-width: 150px; width: 100%; max-width: 200px"
              >
                <label for="" class="mb-2">{{ $t("ResReports.label3") }}</label>
                <v-select :options="optionsDeli"></v-select>
              </div>
              <div
                class="input_wrapper mx-2"
                style="min-width: 150px; width: 100%; max-width: 200px"
              >
                <label for="" class="mb-2">{{ $t("asideRpt.label6") }}</label>
                <v-select :options="optionsPayment"></v-select>
              </div>
              <div
                class="input_wrapper mx-2"
                style="min-width: 150px; width: 100%; max-width: 200px"
              >
                <label for="" class="mb-2">{{ $t("asideRpt.label7") }}</label>
                <v-select :options="options"></v-select>
              </div>
            </div>
          </div>
          <div class="col-12">
            <button
              class="
                border-0
                rounded
                px-4
                py-2
                text-light
                bg_primary
                focus_primary
              "
              type="button"
            >
              {{ $t("filterBtn") }}
            </button>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-12">
          <div
            class="
              flex_wrapper
              d-flex
              justify-content-center
              align-items-stretch
            "
          >
            <CustomCard :num="this.cardNum1" title="ResReports.cardSm1" />
            <CustomCard :num="this.cardNum2" title="ResReports.cardSm2" />
            <CustomCard :num="this.cardNum3" title="ResReports.cardSm3" />
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-hover" style="min-width: 1200px">
              <thead>
                <tr>
                  <th
                    v-for="item in thead"
                    :key="item"
                    class="pt-3 bg-dark text-light"
                  >
                    <h5 class="fs_small text-center">{{ $t(item) }}</h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="15" class="text-center">
                    <span class="text-secondary">{{ $t("noData") }}</span>
                  </td>
                </tr>
                <tr>
                  <td align="center" valign="middle">
                    <p class="m_0">1023215</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">16/06/2021 12:40</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">16/06/2021 12:55</p>
                  </td>
                  <td align="center" valign="middle">
                    <small>arrival at the store 12:50</small>
                    <p class="m_0 badge bg-success d-block">Delivered</p>
                    <small>delivered at 1:14 pm</small>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Túlio Amadeu</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">R$7,00</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Money</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Coast and Desk</p>
                  </td>
                  <td align="center" valign="middle">
                    <button
                      type="button"
                      class="border-0 rounded btn-warning text-light px-2 py-1"
                    >
                      <fa icon="eye" />
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
import { API } from "../../../axois.js";
import CustomCard from "../home/card.vue";
export default {
  name: "ResReports",
  title: "Reports | Dashboard",
  components: { CustomCard },
  data() {
    return {
      thead: [
        "Order No.",
        "Issue date",
        "departure date",
        "Status",
        "Deliveryman",
        "Rate",
        "Payment",
        "Origin",
        "Details",
      ],
      showType: "search_by_order",
      optionsStatus: ["Finalized "],
      filter: "",
    };
  },
  created() {},
  mounted() {},
  methods: {},
};
</script>

