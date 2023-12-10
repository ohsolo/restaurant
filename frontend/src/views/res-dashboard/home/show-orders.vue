<template>
  <form
    autocomplete="off"
    class="az_globalForm"
    ref="myForm"
    @submit.prevent="applyFilters"
    :key="resetFilter"
  >
    <!-- Filters Type -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="d-flex">
          <div>
            <div class="input_wrapper">
              <label for="default">
                <input
                  type="radio"
                  class="form-check-input"
                  name="search"
                  value="default"
                  id="default"
                  checked
                  @click="handleRdBtn($event.target.value)"
                />
                {{ $t("resHome.rd1") }}
              </label>
            </div>
          </div>
          <div class="ms-4">
            <div class="input_wrapper">
              <label for="order">
                <input
                  type="radio"
                  class="form-check-input"
                  name="search"
                  id="order"
                  value="search_by_order"
                  @click="handleRdBtn($event.target.value)"
                />
                {{ $t("resHome.rd2") }}
              </label>
            </div>
          </div>
          <div class="ms-4">
            <div class="input_wrapper">
              <label for="period">
                <input
                  type="radio"
                  class="form-check-input"
                  name="search"
                  value="search_by_period"
                  id="period"
                  @click="handleRdBtn($event.target.value)"
                />
                {{ $t("resHome.rd3") }}
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Filters -->
    <div class="row mt-2">
      <div class="col-12">
        <div class="d-flex flex-wrap">
          <div
            class="input_wrapper mx-2 mt-3"
            style="min-width: 150px; width: 100%; max-width: 200px"
          >
            <label for="" class="mb-2">{{ $t("resHome.Deliverer") }}</label>
            <SearchContent
              url="admin/get-riders-by-name-admin?search="
              objKey="riders"
              myKey="name"
              focus
              @my-call-back="riderCallBack"
            />
          </div>
          <div
            class="input_wrapper mx-2 mt-3"
            style="min-width: 150px; width: 100%; max-width: 200px"
          >
            <label for="" class="mb-2">{{ $t("resHome.Region") }}</label>
            <SearchContent
              url="admin/get-regions-by-name?search="
              objKey="regions"
              myKey="title"
              @my-call-back="regionCallBack"
            />
          </div>
          <div
            class="input_wrapper mx-2 mt-3"
            style="min-width: 150px; width: 100%; max-width: 200px"
          >
            <label for="" class="mb-2">{{ $t("resHome.Status") }}</label>
            <select class="form-select" v-model="filter.status">
              <option value="1">Select option</option>
              <option v-for="item in status_op" :key="item" :value="item.value">
                {{ item.text }}
              </option>
            </select>
          </div>
          <div
            class="input_wrapper mx-2 mt-3"
            style="min-width: 150px; width: 100%; max-width: 200px"
          >
            <label for="" class="fs_small mb-2">
              {{ $t("resHome.Vehicle") }}
            </label>
            <select class="form-select" v-model="filter.vehicle_type">
              <option value="1">Select option</option>
              <option v-for="item in vehicle" :key="item" :value="item.value">
                {{ item.text }}
              </option>
            </select>
          </div>
          <div
            class="input_wrapper mx-2 mt-3"
            style="min-width: 150px; width: 100%; max-width: 200px"
          >
            <label for="" class="mb-2">{{
              $t("resHome.Form_of_payment")
            }}</label>
            <select class="form-select" v-model="filter.form_of_payment">
              <option value="1">Select option</option>
              <option v-for="item in fop" :key="item" :value="item.value">
                {{ item.text }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-lg-8 col-md-6 col-sm-12 mt-3">
        <div class="input_wrapper mt-2" v-if="showType == 'search_by_order'">
          <div class="loadIcon">
            <input
              type="text"
              class="form-control"
              placeholder="Search by order number"
              v-model="filter.order_number"
            />
            <fa icon="search" />
          </div>
        </div>
        <div
          class="input_wrapper mt-2 d-flex"
          v-if="showType == 'search_by_period'"
        >
          <label for="" class="me-3 w-50 d-flex align-items-center">
            <span class="me-2">{{ $t("resHome.From") }}</span>
            <input
              type="date"
              required
              class="form-control"
              v-model="filter.start_date"
            />
          </label>
          <label for="" class="d-flex w-50 align-items-center">
            <span class="me-2">{{ $t("resHome.To") }}</span>
            <input
              type="date"
              required
              v-model="filter.end_date"
              class="form-control"
            />
          </label>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-6 mt-3 align-self-end">
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
          "
        >
          {{ $t("filterBtn") }}
        </button>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-6 mt-3 align-self-end">
        <button
          type="button"
          @click="clearFilters"
          class="
            border-0
            rounded
            px-2
            w-100
            py-2
            text-light
            bg_primary
            focus_primary
          "
        >
          {{ $t("clearBtn") }}
        </button>
      </div>
    </div>
  </form>
  <!-- Cards -->
  <div class="row mt-4">
    <div class="col-12">
      <div
        class="flex_wrapper d-flex justify-content-center align-items-stretch"
      >
        <CustomCard :num="cardsData?.card1 ?? '0'" title="resHome.cardSm1" />
        <CustomCard :num="cardsData?.card2 ?? '0'" title="resHome.cardSm2" />
        <CustomCard :num="cardsData?.card3 ?? '0'" title="resHome.cardSm3" />
        <CustomCard :num="cardsData?.card4 ?? '0'" title="resHome.cardSm4" />
      </div>
    </div>
  </div>
  <!-- Data Table -->
  <div class="row mt-5 mb-5">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-hover" style="min-width: 1200px">
          <thead>
            <tr>
              <th
                v-for="item in 11"
                :key="item"
                class="pt-3 bg-dark text-light"
              >
                <h5 class="fs_small text-center">
                  {{ $t(`resHome.th${item}`) }}
                </h5>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td
                colspan="12"
                v-if="!records?.data.length"
                class="py-3"
                align="center"
              >
                <span class="text-secondary">{{ $t("noData") }}</span>
              </td>
            </tr>
            <tr v-for="data in records?.data" :key="data?.order_id">
              <td align="center" valign="middle">
                <p class="m_0">{{ data.order_number }}</p>
              </td>
              <td align="center" valign="middle">
                <p class="m_0">
                  {{ data.created_at ? printDate(data.created_at) : "-" }}
                  <br />
                  {{ data.created_at ? printTime(data.created_at) : "-" }}
                </p>
              </td>
              <td align="center" valign="middle">
                <p class="m_0">
                  {{ data.pickup_time ? data.pickup_time : "-" }}
                </p>
              </td>
              <td align="center" valign="middle">
                <p class="m_0">
                  {{ data.output_time ? data.output_time : "-" }}
                </p>
              </td>
              <td align="center" valign="middle">
                <p class="m_0">{{ !data?.rider ? "-" : "rider" }}</p>
              </td>
              <td align="center" valign="middle">
                <p class="m_0" v-if="!data?.rider">-</p>
                <div v-else>
                  <fa class="t_primary" v-if="'car' == 'car'" icon="car" />
                  <fa
                    class="t_primary"
                    v-if="'car' == 'bike'"
                    icon="motorcycle"
                  />
                  <fa
                    class="t_primary"
                    v-if="'car' == 'bicycle'"
                    icon="bicycle"
                  />
                </div>
              </td>
              <td align="center" valign="middle">
                <p class="m_0">$-</p>
              </td>
              <td align="center" valign="middle">
                <p class="m_0">
                  {{
                    data.payment_method == "online"
                      ? "Online"
                      : "Cash on delivery"
                  }}
                </p>
              </td>
              <td align="center" valign="middle">
                <router-link
                  :to="{ name: 'SingleOrder', params: { id: data.order_id } }"
                  class="border-0 rounded btn-warning text-light px-2 py-1"
                  title="View Order Details"
                >
                  <fa icon="eye" />
                </router-link>
              </td>
              <td align="center" valign="middle">
                <small
                  :class="[
                    'badge text-light',
                    data.status == 'rejected'
                      ? 'bg-secondary'
                      : data.status == 'pending'
                      ? 'bg-success'
                      : 'bg_primary',
                  ]"
                  >{{
                    data?.status == "pending"
                      ? "Inprocess"
                      : data?.status == "research"
                      ? "searching"
                      : data?.status == "rejected"
                      ? "cancelled"
                      : data?.status
                  }}</small
                >
              </td>
              <td align="center" valign="middle">
                <button
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal3"
                  type="button"
                  class="border-0 rounded px-2 py-1"
                  @click="() => (rejectedOrderId = data?.order_id)"
                  title="Remove Rider"
                  v-if="data?.status == 'pending'"
                >
                  <fa icon="check" class="text-success" />
                </button>
                <button
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal1"
                  type="button"
                  class="border-0 rounded px-2 py-1"
                  title="Remove Rider"
                  @click="() => getFeedback(data.order_id)"
                  v-if="data?.status == 'delivered'"
                >
                  <fa icon="star" class="t_primary" />
                </button>
                <span v-else>-</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="myPagination28 mt-4">
        <pagination
          v-model="page"
          :records="records?.total * 1"
          :per-page="records?.per_page"
          @paginate="paginationCallback($event)"
        />
      </div>
    </div>
  </div>
  <!-- Feedback modal -->
  <div
    class="modal fade"
    id="exampleModal1"
    tabindex="-1"
    aria-labelledby="exampleModal1Label"
    aria-hidden="true"
    ref="close_myModal"
  >
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <button
                type="button"
                class="btn ms-auto d-block focus_primary fs-4"
                style="line-height: 0"
                data-bs-dismiss="modal"
                aria-label="Close"
              >
                <fa icon="times" class="t_primary" />
              </button>
            </div>
          </div>
          <div class="col-sm-12">
            <h4 class="t_primary text-center mb-4">
              {{ $t("fdModal.Feedback") }}
            </h4>
          </div>
          <div class="col-12 text-center" v-if="isFeedbackLoading">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
          <div class="col-12" v-else>
            <!-- rider rating -->
            <h5 class="t_primary mb-3">{{ $t("fdModal.Rider") }}</h5>
            <div class="mb-4" v-if="feedbackData?.rider_rating !== null">
              <div class="d-flex justify-content-between">
                <p class="fw-bold">{{ $t("fdModal.Total_Rating") }}</p>
                <div>
                  <template v-for="star in 5" :key="star">
                    <fa
                      icon="star"
                      :class="
                        star <= feedbackData?.rider_rating.rating
                          ? 'text-warning'
                          : 'text-secondary'
                      "
                    />
                  </template>
                  <span class="fw-bold text-secondary"
                    >({{ feedbackData?.rider_rating?.rating }})</span
                  >
                </div>
              </div>
              <div class="" v-if="feedbackData?.rider_rating_questions.length">
                <p class="fw-bold">{{ $t("fdModal.Rating_Question") }}</p>
                <template
                  v-for="x in feedbackData?.rider_rating_questions"
                  :key="x?.id"
                >
                  <div class="d-flex justify-content-between">
                    <p>{{ x.question }}</p>
                    <div>
                      <template v-for="star in 5" :key="star">
                        <fa
                          icon="star"
                          :class="
                            star <= x.rating ? 'text-warning' : 'text-secondary'
                          "
                        />
                      </template>
                    </div>
                  </div>
                </template>
              </div>
            </div>
            <div class="mb-4" v-if="feedbackData?.rider_rating == null">
              <p class="text-secondary text-center">
                {{ $t("fdModal.msg") }}
              </p>
            </div>
            <!-- restaurant rating -->
            <h5 class="t_primary mb-3">{{ $t("fdModal.Restaurant") }}</h5>
            <div class="mb-4" v-if="feedbackData?.rest_rating !== null">
              <div class="d-flex justify-content-between">
                <p class="fw-bold">{{ $t("fdModal.Total_Rating") }}</p>
                <div>
                  <template v-for="star in 5" :key="star">
                    <fa
                      icon="star"
                      :class="
                        star <= feedbackData?.rest_rating.rating
                          ? 'text-warning'
                          : 'text-secondary'
                      "
                    />
                  </template>
                  <span class="fw-bold text-secondary"
                    >({{ feedbackData?.rest_rating?.rating }})</span
                  >
                </div>
              </div>
              <div class="" v-if="feedbackData?.rest_rating_questions.length">
                <p class="fw-bold">{{ $t("fdModal.Rating_Question") }}</p>
                <template
                  v-for="x in feedbackData?.rest_rating_questions"
                  :key="x?.id"
                >
                  <div class="d-flex justify-content-between">
                    <p>{{ x.question }}</p>
                    <div>
                      <template v-for="star in 5" :key="star">
                        <fa
                          icon="star"
                          :class="
                            star <= x.rating ? 'text-warning' : 'text-secondary'
                          "
                        />
                      </template>
                    </div>
                  </div>
                </template>
              </div>
            </div>
            <div class="mb-4" v-if="feedbackData?.rest_rating == null">
              <p class="text-secondary text-center">
                {{ $t("fdModal.msg") }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- cancel order -->
  <div
    class="modal fade"
    id="exampleModal3"
    tabindex="-1"
    aria-labelledby="exampleModal3Label"
    aria-hidden="true"
    ref="close_myModal"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <button
                type="button"
                class="btn ms-auto d-block focus_primary fs-4"
                style="line-height: 0"
                data-bs-dismiss="modal"
                aria-label="Close"
              >
                <fa icon="times" class="t_primary" />
              </button>
            </div>
          </div>
          <h5 class="text-center mb-4">
            {{ $t("cnclOrderModal.reason") }}<span class="text-danger">*</span>
          </h5>
          <form action="" class="" @submit.prevent="rejectOrder">
            <div class="row mt-4">
              <div class="col-12">
                <div class="input_wrapper">
                  <textarea
                    class="form-control"
                    cols="30"
                    rows="3"
                    required
                    v-model="reason"
                    placeholder="Descreva or reason"
                  ></textarea>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 text-center">
                <button
                  type="button"
                  data-bs-dismiss="modal"
                  class="btn px-5 text-light btn-secondary"
                  ref="close_myModal"
                >
                  {{ $t("cnclOrderModal.close") }}
                </button>
                <input
                  type="submit"
                  class="ms-3 px-5 btn focus_primary text-light bg_primary"
                  value="Send"
                />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import { API } from "../../../axois.js";
import SearchContent from "../../../components/admin-components/search-content/index.vue";
import CustomCard from "./card.vue";
import Pagination from "v-pagination-3";
import moment from "moment";

export default {
  name: "ShowOrders",
  components: { SearchContent, Pagination, CustomCard },
  data() {
    return {
      showType: "default",
      options: [],
      vehicle: [
        {
          value: "bike",
          text: "Bike",
        },
        {
          value: "car",
          text: "Car",
        },
        {
          value: "bicycle",
          text: "Bicycle",
        },
      ],
      fop: [
        {
          value: "cash_on_delivery",
          text: "Cash on delivery",
        },
        {
          value: "online",
          text: "Online",
        },
      ],
      status_op: [
        {
          value: "research",
          text: "Searching",
        },
        {
          value: "rejected",
          text: "Cancelled",
        },
        {
          value: "pending",
          text: "Inprocess",
        },
        {
          value: "delivered",
          text: "Delivered",
        },
      ],
      records: null,
      page: 1,
      applyFilter: false,
      filter: {
        by_period: "0",
        by_procured: "0",
        status: "1",
        deliverer_id: "",
        region_id: "",
        start_date: "",
        end_date: "",
        order_number: "",
        form_of_payment: "1",
        vehicle_type: "1",
      },
      resetFilter: 1,
      reason: "",
      rejectedOrderId: null,
      cardsData: null,
      isFeedbackLoading: false,
      feedbackData: null,
    };
  },
  created() {
    this.getRecords();
  },
  mounted() {},
  methods: {
    fd() {
      let fd = new FormData();
      fd.append("page", this.page);
      fd.append("per_page", 20);
      if (this.applyFilter) {
        let f = this.filter;
        fd.append("by_period", f.by_period);
        fd.append("by_procured", f.by_procured);
        if (f.status !== "1" || !f.status) {
          fd.append("status", f.status);
        }
        if (f.form_of_payment !== "1" || !f.form_of_payment) {
          fd.append("form_of_payment", f.form_of_payment);
        }
        if (f.vehicle_type !== "1" || !f.vehicle_type) {
          fd.append("vehicle_type", f.vehicle_type);
        }
        if (f.order_number != "") {
          fd.append("order_number", f.order_number);
        }
        if (f.deliverer_id !== "") {
          fd.append("deliverer_id", f.deliverer_id);
        }
        if (f.region_id !== "") {
          fd.append("region_id", f.region_id);
        }
        if (f.start_date !== "") {
          fd.append("start_date", f.start_date);
        }
        if (f.end_date !== "") {
          fd.append("end_date", f.end_date);
        }
      }
      return fd;
    },
    getRecords() {
      this.$store.commit("loaderShow");
      let fd = this.fd();
      API(this, "rest/get-orders", "post", fd)
        .then((res) => {
          this.records = res?.data?.response?.detail?.orders;
          this.cardsData = {
            card1: res?.data?.response?.detail?.deliveries_not_period,
            card2: res?.data?.response?.detail?.deliveries_canceled_no_period,
            card3: res?.data?.response?.detail?.gross_profit,
            card4: res?.data?.response?.detail?.net_profit,
          };
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: show-orders.vue ~ getRecords ~ err", err);
          this.$store.commit("loaderHide");
        });
    },
    // Pagination callback
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
    // Filter type
    handleRdBtn(value) {
      this.showType = value;
      if (value == "search_by_order") {
        this.filter.by_period = "0";
        this.filter.by_procured = "1";
      }
      if (value == "search_by_period") {
        this.filter.by_period = "1";
        this.filter.by_procured = "0";
      }
      if (value == "default") {
        this.filter.by_period = "0";
        this.filter.by_procured = "0";
      }
    },
    riderCallBack(item) {
      if (item == "") {
        this.filter.deliverer_id = "";
      } else {
        this.filter.deliverer_id = item.region_id;
      }
    },
    regionCallBack(item) {
      if (item == "") {
        this.filter.region_id = "";
      } else {
        this.filter.region_id = item.region_id;
      }
    },
    applyFilters() {
      this.applyFilter = true;
      this.page = 1;
      this.getRecords();
    },
    clearFilters() {
      this.applyFilter = false;
      (this.filter = {
        by_period: "0",
        by_procured: "1",
        status: "1",
        deliverer_id: "",
        region_id: "",
        start_date: "",
        end_date: "",
        order_number: "",
        form_of_payment: "1",
        vehicle_type: "1",
      }),
        (this.resetFilter += 1);
      this.page = 1;
      this.getRecords();
    },
    rejectOrder() {
      if (this.rejectedOrderId !== null) {
        this.$store.commit("loaderShow");
        this.$refs.close_myModal.click();
        API(this, `rest/rest-remove-rider/${this.rejectedOrderId}`, "post", {
          reason: this.reason,
        })
          .then((res) => {
            this.rejectedOrderId = null;
            this.reason = null;
            this.$store.dispatch("SuccessToast", {
              message: res.data.response.message,
            });
            this.getRecords();
            this.$store.commit("loaderHide");
          })
          .catch((err) => {
            console.error("🚀 ~ file: show-orders.vue ~ getRecords ~ err", err);
            this.$store.commit("loaderHide");
          });
      }
    },
    printDate(dt) {
      return moment(dt).format("L");
    },
    printTime(dt) {
      return moment(dt).format("HH:mm");
    },
    getFeedback(id) {
      this.isFeedbackLoading = true;
      API(this, `rest/get-rating-of-order/${id}`, "get")
        .then((res) => {
          this.feedbackData = res.data.response.detail;
          this.isFeedbackLoading = false;
        })
        .catch((err) => {
          console.error("🚀 ~ file: show-orders.vue ~ getFeedback ~ err", err);
          this.isFeedbackLoading = false;
        });
    },
  },
};
</script>
  
  