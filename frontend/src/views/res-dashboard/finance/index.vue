<template>
  <section class="finance_page">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold">Financial</h4>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <div
            class="
              flex_wrapper
              d-flex
              justify-content-center
              align-items-stretch
            "
          >
            <CustomCard :num="this.cardNum1" title="ResFin.cardSm1" />
            <CustomCard :num="this.cardNum2" title="ResFin.cardSm2" />
            <CustomCard :num="this.cardNum3" title="ResFin.cardSm3" />
          </div>
        </div>
      </div>
      <div class="row mt-2 py-4 align-items-stretch">
        <div class="col-xl-4 col-lg-6 mt-3">
          <form class="h-100">
            <div class="az_card1 rounded p-xl-4 p-3 border">
              <div class="head">
                <h5 class="mb-0 py-2 border-bottom">
                  {{ $t("ResFin.cardh1") }}
                </h5>
              </div>
              <div class="body_con py-3">
                <p class="mb-0">{{ $t("ResFin.card1para") }}</p>
                <small class="fw-bold">{{ $t("ResFin.card1small") }}</small>
                <div class="input_wrapper my-3">
                  <label for="" class="w-100">
                    <small class="mb-2 d-block">{{
                      $t("ResFin.card1label")
                    }}</small>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="100"
                      value="100"
                    />
                  </label>
                </div>
                <small class="me-2"
                  >{{ $t("ResFin.card1small2half") }}
                  <b>{{ $t("ResFin.card1b1") }}</b>
                  {{ $t("ResFin.card1small2") }}
                </small>
                <div class="d-flex flex-wrap justify-content-around mt-4">
                  <button
                    class="
                      border-0
                      rounded
                      px-2
                      w-100
                      py-2
                      text-light
                      bg_primary
                      focus_primary
                      mt-2
                    "
                    type="button"
                    style="max-width: 200px"
                  >
                    {{ $t("ResFin.btn1") }}
                  </button>
                  <button
                    class="
                      border-0
                      rounded
                      px-2
                      w-100
                      py-2
                      text-light
                      bg_primary
                      focus_primary
                      mt-2
                    "
                    type="button"
                    style="max-width: 200px"
                  >
                    {{ $t("ResFin.btn2") }}
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-xl-4 col-lg-6 mt-3">
          <form class="h-100">
            <div class="az_card1 rounded h-100 p-xl-4 p-3 border">
              <div class="head">
                <h5 class="mb-0 py-2 border-bottom">
                  {{ $t("ResFin.cardh2") }}
                </h5>
              </div>
              <div class="body_con py-3">
                <div class="mt-3">
                  <button
                    class="
                      border-0
                      rounded
                      px-2
                      w-100
                      py-2
                      mb-2
                      text-light
                      bg_primary
                      focus_primary
                    "
                    type="button"
                  >
                    {{ $t("ResFin.btn3") }}
                  </button>
                  <button
                    class="
                      border-0
                      rounded
                      px-2
                      w-100
                      py-2
                      text-light
                      bg-secondary
                      focus_primary
                    "
                    type="button"
                  >
                    {{ $t("ResFin.btn4") }}
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-xl-4 col-lg-6 mt-3">
          <form class="h-100">
            <div class="az_card1 rounded h-100 p-xl-4 p-3 border">
              <div class="head">
                <h5 class="mb-0 py-2 border-bottom">
                  {{ $t("ResFin.cardh3") }}
                </h5>
              </div>
              <div class="body_con py-3">
                <div class="z_ticket d-flex align-items-center mb-3">
                  <div
                    class="img_wrapper bg-light overflow-hidden"
                    style="
                      width: 80px;
                      height: 80px;
                      border-radius: 100%;
                      min-width: 80px;
                    "
                  >
                    <img :src="null" class="img_fluid" />
                  </div>
                  <div class="tic_body ms-3">
                    <h5 class="mb-0"><b>Rs</b> 100.00</h5>
                    <small>Vencimentor 19/06/2022</small>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-12 mb-3">
          <h4 class="sec_hd t_primary fw-bold">Movement</h4>
        </div>
        <div class="col-12 d-md-flex flex-wrap justify-content-between">
          <div class="col_left" style="flex: 1">
            <button
              class="
                border-0
                rounded
                px-2
                w-100
                py-2
                text-light
                mb-2
                me-3
                focus_primary
                bg_primary
              "
              style="max-width: 150px"
              type="button"
              value="credit"
              :class="this.showType == 'credit' ? 'bg_primary' : 'bg-secondary'"
              @click="handleRdBtn($event.target.value)"
            >
              <!-- {{ $t("RestaurantBtn") }} -->
              credits
            </button>
            <button
              class="
                border-0
                rounded
                px-2
                w-100
                py-2
                text-light
                focus_primary
                mb-2
              "
              style="max-width: 150px"
              value="debts"
              type="button"
              :class="this.showType == 'debts' ? 'bg_primary' : 'bg-secondary'"
              @click="handleRdBtn($event.target.value)"
            >
              <!-- {{ $t("ResReports.label3") }} -->
              debts
            </button>
            <form>
              <div
                class="input_wrapper d-flex mb-3 align-items-end flex-wrap mt-3"
              >
                <label for="" class="me-3">
                  <span class="mb-2 d-block">{{
                    $t("asideRpt.calenTxt1")
                  }}</span>
                  <input
                    type="date"
                    class="form-control py-1"
                    style="max-width: 150px"
                  />
                </label>
                <label for="" class="me-3">
                  <span class="mb-2 d-block">{{
                    $t("asideRpt.calenTxt2")
                  }}</span>
                  <input
                    type="date"
                    class="form-control py-1"
                    style="max-width: 150px"
                  />
                </label>
                <button
                  class="
                    border-0
                    rounded
                    px-2
                    w-100
                    py-1
                    text-light
                    focus_primary
                    bg_primary
                  "
                  style="max-width: 120px"
                  value="debts"
                  type="button"
                >
                  {{ $t("filterBtn") }}
                </button>
              </div>
            </form>
          </div>
          <div class="col_right mt-3 mt-md-0" v-if="this.showType == 'debts'">
            <div class="card border-0 shadow p-3 text-end">
              <h4>R$11,50</h4>
              <small>Total discounted in the period </small>
              <!-- <CustomCard :num="this.cardNum1" title="ResFin.cardSm1" /> -->
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <div class="table-responsive">
            <table
              class="table table-hover text-center"
              style="min-width: 1200px"
              v-if="this.showType == 'credit'"
            >
              <thead>
                <tr>
                  <th
                    v-for="item in thead"
                    :key="item"
                    class="pt-3 bg-dark text-light"
                  >
                    <h5 class="fs_small">{{ $t(item) }}</h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <!-- <tr>
                  <td colspan="15" class="text-center">
                    <span class="text-secondary">{{ $t("noData") }}</span>
                  </td>
                </tr> -->
                <tr>
                  <td valign="middle" class="py-3">
                    <p class="mb_0">10/06/2021 21:30</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">R$100,00</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">Ticket</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">25597195</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">processing</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">****6351</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">2379182580000010000338</p>
                    <p class="m_0">0250002559720300633330</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <router-link
                      to="/credit-card"
                      class="
                        border-0
                        btn-info
                        py-1
                        text-light
                        rounded
                        px-2
                        me-1
                      "
                    >
                      <fa icon="eye" />
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
            <table
              class="table table-hover text-center"
              style="min-width: 1200px"
              v-if="this.showType == 'debts'"
            >
              <thead>
                <tr>
                  <th
                    v-for="item in theadDebts"
                    :key="item"
                    class="pt-3 bg-dark text-light"
                  >
                    <h5 class="fs_small">{{ $t(item) }}</h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <!-- <tr>
                  <td colspan="15" class="text-center">
                    <span class="text-secondary">{{ $t("noData") }}</span>
                  </td>
                </tr> -->
                <tr>
                  <td valign="middle" class="py-3">
                    <p class="mb_0">10/06/2021 21:30</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="mb_0">1276</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">Avenida Doutor Altino Arantes, 100</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">Downtown / San Sebastian</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0">R$5,00</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <p class="m_0 badge bg-success">Delivered</p>
                  </td>
                  <td valign="middle" class="py-3">
                    <router-link
                      to="/credit-card"
                      class="
                        border-0
                        btn-info
                        py-1
                        text-light
                        rounded
                        px-2
                        me-1
                      "
                    >
                      <fa icon="eye" />
                    </router-link>
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
  name: "ResFinance",
  title: "Finance | Dashboard",
  components: { CustomCard },
  data() {
    return {
      thead: [
        "Date",
        "Value",
        "Guy",
        "Payment ID",
        "Status",
        "Card",
        "Barcode",
        "Details",
      ],
      theadDebts: [
        "Date",
        "No Delivery",
        "Address / No.",
        "Neighborhood / City",
        "Rate",
        "Status",
        "Details",
      ],
      cardNum1: "R$54,75",
      cardNum2: "R$245,00",
      cardNum3: "3",
      showType: "credit",
    };
  },
  created() {},
  mounted() {},
  methods: {
    handleRdBtn(value) {
      this.showType = value;
    },
  },
};
</script>

