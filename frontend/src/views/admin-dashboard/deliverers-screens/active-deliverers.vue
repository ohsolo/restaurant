<template>
  <div class="az_awaiting_approval">
    <section class="az_filterable_table">
      <div class="container-fluid">
        <div class="filter_wrapper">
          <div class="az_globalForm">
            <div class="az_display_flex">
              <div class="d-flex">
                <div class="input_wrapper">
                  <div class="loadIcon">
                    <input type="text" class="form-control" v-model="search" />
                    <fa icon="search" />
                  </div>
                </div>
                <div>
                  <button
                    class="btn w-100 bg_primary text-light focus_primary"
                    @click="searchValue"
                    type="button"
                  >
                    {{ $t("active_del.searchBtn") }}
                  </button>
                </div>
              </div>
              <div class="d-flex">
                <div class="input_wrapper">
                  <label for="" class="fs_small mb-1">
                    {{ $t("active_del.label1") }}
                  </label>
                  <select
                    class="form-select"
                    @change="filterRegion()"
                    v-model="selectedRegion"
                  >
                    <option selected>Every where</option>
                    <option
                      v-for="item in regionData"
                      :key="item.region_id"
                      :value="item.region_id"
                    >
                      {{ item.title }}
                    </option>
                  </select>
                </div>
                <div class="input_wrapper">
                  <label for="" class="fs_small mb-1">
                    {{ $t("active_del.label2") }}
                  </label>
                  <select
                    class="form-select"
                    @change="filterVehicle()"
                    v-model="selectedVehicle"
                  >
                    <option selected>All</option>
                    <option
                      v-for="item in vehicle"
                      :key="item"
                      :value="item.value"
                    >
                      {{ item.text }}
                    </option>
                  </select>
                </div>
                <div>
                  <button
                    class="btn w-100 bg_primary text-light focus_primary"
                    type="button"
                    @click="clearFilter"
                  >
                    {{ $t("active_del.clearBtn") }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover pm_0">
            <thead>
              <tr>
                <th v-for="item in th" :key="item" class="text-light bg-dark">
                  <h5 class="m_0 text-center">{{ $t(item) }}</h5>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td v-if="records?.data == ''" colspan="11" class="text-center">
                  <span>{{ $t("active_del.notFound") }} </span>
                </td>
              </tr>
              <tr v-for="data in records?.data" :key="data">
                <td>
                  <p class="m_0 text-center">{{ data.name }}</p>
                </td>
                <td class="text-center">
                  <fa
                    class="t_primary"
                    v-if="data.vehicle_type == 'car'"
                    icon="car"
                  />
                  <fa
                    class="t_primary"
                    v-if="data.vehicle_type == 'bike'"
                    icon="motorcycle"
                  />
                  <fa
                    class="t_primary"
                    v-if="data.vehicle_type == 'bicycle'"
                    icon="bicycle"
                  />
                </td>
                <td>
                  <p class="m_0 text-center">{{ data.cpf }}</p>
                </td>
                <td class="text-center">
                  <a
                    class="border-0 btn-warning py-1 text-light rounded px-2"
                    :href="data.profile_image_url"
                    target="_blank"
                    rel="noopener"
                  >
                    <fa icon="eye" />
                  </a>
                </td>
                <td class="text-center">
                  <a
                    class="border-0 btn-warning py-1 text-light rounded px-2"
                    :href="data.cnh_image_url"
                    target="_blank"
                    rel="noopener"
                  >
                    <fa icon="eye" />
                  </a>
                </td>
                <td>
                  <p class="m_0 text-center">{{ data.phone }}</p>
                </td>
                <td>
                  <p class="m_0 text-center">{{ data.email }}</p>
                </td>
                <td>
                  <p class="m_0 text-center">{{ data.region.title }}</p>
                </td>
                <td class="text-center">
                  <button
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    class="border-0 btn-warning py-1 text-light rounded px-2"
                    @click="setBankDetails(data.bank_detail)"
                  >
                    <fa icon="eye" />
                  </button>
                </td>
                <td class="text-center">{{ dateTime(data.created_at) }}</td>
                <td class="text-center">
                  <button
                    type="button"
                    class="border-0 bg-secondary py-1 text-light rounded px-2"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal2"
                    @click="setRiderHistory(data.rider_id)"
                  >
                    Details
                  </button>
                </td>
                <td class="text-center">
                  <!-- block -->
                  <button
                    class="
                      btn-secondary
                      text-light
                      border-0
                      me-2
                      px-2
                      py-1
                      rounded
                    "
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal3"
                    @click="
                      () => {
                        blockDriver.id = data.rider_id;
                      }
                    "
                  >
                    <fa icon="lock" />
                  </button>
                  <button
                    type="button"
                    class="btn-danger border-0 px-2 py-1 text-light rounded"
                    @click="
                      () => {
                        excludeID = data.rider_id;
                      }
                    "
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal4"
                  >
                    <fa icon="times-circle" />
                  </button>
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
    </section>
  </div>
  <!-- Bank Details 1 -->
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
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

          <div class="row">
            <div class="col-12">
              <h5
                class="t_primary text-center fw-bold"
                style="margin-top: -15px"
              >
                Bank Details
              </h5>
              <hr />
            </div>
          </div>

          <form action="" class="az_globalForm my-4" v-if="bankDetails != null">
            <div class="input_wrapper row">
              <div class="col-4 align-self-center">
                <label for="" class="fs_small">Bank</label>
              </div>
              <div class="col-8">
                <input
                  type="text"
                  name=""
                  class="form-control"
                  id=""
                  :value="bankDetails.bank"
                />
              </div>
            </div>
            <div class="input_wrapper row mt-4">
              <div class="col-4 align-self-center">
                <label for="" class="fs_small">Agency</label>
              </div>
              <div class="col-8">
                <input
                  type="text"
                  name=""
                  class="form-control"
                  id=""
                  :value="bankDetails.agency"
                />
              </div>
            </div>
            <div class="input_wrapper row mt-4">
              <div class="col-4 align-self-center">
                <label for="" class="fs_small">Agency verification digit</label>
              </div>
              <div class="col-8">
                <input
                  type="text"
                  name=""
                  class="form-control"
                  id=""
                  value=""
                />
              </div>
            </div>
            <div class="input_wrapper row mt-4">
              <div class="col-4 align-self-center">
                <label for="" class="fs_small">Count</label>
              </div>
              <div class="col-8">
                <input
                  type="text"
                  name=""
                  class="form-control"
                  id=""
                  :value="bankDetails.account"
                />
              </div>
            </div>
            <div class="input_wrapper row mt-4">
              <div class="col-4 align-self-center">
                <label for="" class="fs_small">Account verifier digit</label>
              </div>
              <div class="col-8">
                <input
                  type="text"
                  name=""
                  class="form-control"
                  id=""
                  :value="bankDetails.account_verification_code"
                />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- History -->
  <div
    class="modal fade"
    id="exampleModal2"
    tabindex="-1"
    aria-labelledby="exampleModal2Label"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
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
          <div class="row">
            <div class="col-12">
              <h5
                class="text-center t_primary fw-bold"
                style="margin-top: -15px"
              >
                History
              </h5>
              <hr />
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-center" v-if="isHistoryLoading">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
            <div class="col-12 px-4" v-else>
              <p class="mb-2">
                Registration made on
                {{
                  riderHistory?.joining_date
                    ? printDate(riderHistory?.joining_date)
                    : "-"
                }}
              </p>
              <p class="mb-2">
                Last login on
                {{
                  riderHistory?.last_login
                    ? printDate(riderHistory?.last_login)
                    : "-"
                }}
                {{
                  riderHistory?.last_login
                    ? printTime(riderHistory?.last_login)
                    : "-"
                }}
              </p>
              <p class="mb-2">
                {{ riderHistory?.delivered_order_count ?? "-" }} orders
                delivered
              </p>
              <p class="mb-2">
                {{ riderHistory?.cancelled_order_count ?? "-" }} orders canceled
              </p>
              <p class="mb-2">
                {{ riderHistory?.occurences_found ?? "-" }} occurrences reported
                by restaurants
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Block Profile -->
  <div
    class="modal fade"
    id="exampleModal3"
    tabindex="-1"
    aria-labelledby="exampleModal3Label"
    aria-hidden="true"
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
          <h5 class="text-center mb-4">Do you want to inform or reason?</h5>
          <form action="" class="" @submit.prevent="blockRequest">
            <div class="row">
              <div class="col-12">
                <div class="input_wrapper">
                  <label for="rd-btn1">
                    <input
                      type="radio"
                      class="form-check-input me-1"
                      name="reason"
                      id="rd-btn1"
                      :checked="blockDriver.infoStatus == 'none'"
                      value="none"
                      @change="handleModalRdBtn($event.target.value)"
                    />
                    None
                  </label>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12">
                <div class="input_wrapper">
                  <label for="rd-btn2">
                    <input
                      type="radio"
                      class="form-check-input me-1"
                      name="reason"
                      id="rd-btn2"
                      :checked="blockDriver.infoStatus == 'yes'"
                      value="yes"
                      @change="handleModalRdBtn($event.target.value)"
                    />
                    Yes
                  </label>
                </div>
              </div>
            </div>
            <div class="row mt-4" v-if="blockDriver.infoStatus != 'none'">
              <div class="col-12">
                <div class="input_wrapper">
                  <textarea
                    name=""
                    id=""
                    class="form-control"
                    cols="30"
                    rows="3"
                    :value="blockDriver.msg"
                    :required="blockDriver.infoStatus == 'yes'"
                    placeholder="Descreva or reason"
                    @change="handleTextarea($event.target.value)"
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
                  Close
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
  <!-- Delete Profile -->
  <div
    class="modal fade"
    id="exampleModal4"
    tabindex="-1"
    aria-labelledby="exampleModal4Label"
    aria-hidden="true"
    ref="close_myModal1"
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
          <h5 class="text-center mb-4">Do you want to delete this record?</h5>
          <div class="text-center">
            <button
              type="button"
              data-bs-dismiss="modal"
              aria-label="Close"
              class="btn-secondary px-2 me-2 py-1 border-0 text-light"
            >
              No
            </button>
            <button
              type="button"
              @click="excludeRecord(excludeID)"
              class="btn-danger px-2 py-1 border-0 text-light"
            >
              Yes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { API } from "../../../axois.js";
import moment from "moment";
import Pagination from "v-pagination-3";
export default {
  name: "ActiveDeliverers",
  title: "Riders Active Deliverers | Dashbaord",
  components: { Pagination },
  data() {
    return {
      page: 1,
      th: [
        "active_del.th1",
        "active_del.th2",
        "active_del.th3",
        "active_del.th4",
        "active_del.th5",
        "active_del.th6",
        "active_del.th7",
        "active_del.th8",
        "active_del.th9",
        "active_del.th10",
        "active_del.th11",
        "active_del.th12",
      ],
      search: null,
      excludeID: null,
      regionData: [],
      selectedRegion: "Every where",
      blockDriver: {
        infoStatus: "none",
        id: null,
        msg: "",
      },
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
      selectedVehicle: "All",
      records: null,
      bankDetails: null,
      riderHistory: null,
      isHistoryLoading: null,
    };
  },
  mounted() {},
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      const fd = new FormData();
      fd.append("status", "active");
      fd.append("page", this.page);
      if (
        this.selectedVehicle != null &&
        this.selectedVehicle != "" &&
        this.selectedVehicle != "All"
      ) {
        fd.append("vehicle", this.selectedVehicle);
      }
      if (
        this.selectedRegion != null &&
        this.selectedRegion != "" &&
        this.selectedRegion != "Every where"
      ) {
        fd.append("region_id", this.selectedRegion);
      }
      if (this.search != null && this.search != "") {
        fd.append("search", this.search);
      }
      API(this, "admin/get-riders", "post", fd)
        .then((response) => {
          const Data = response.data.response.detail;
          this.records = Data.riders;
          this.regionData = Data.regions;
          this.$store.commit("loaderHide");
        })
        .catch((error) => {
          console.error(
            "🚀 ~ file: active-deliverers.vue ~ getRecords ~ error",
            error
          );
          this.$store.commit("loaderHide");
        });
    },
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
    filterRegion() {
      this.page = 1;
      this.getRecords();
    },
    filterVehicle() {
      this.page = 1;
      this.getRecords();
    },
    searchValue() {
      if (this.search != null && this.search != "") {
        this.page = 1;
        this.getRecords();
      }
    },
    clearFilter() {
      this.search = null;
      this.selectedVehicle = "All";
      this.selectedRegion = "Every where";
      this.getRecords();
    },
    handleModalRdBtn(value) {
      this.blockDriver.infoStatus = value;
    },
    handleTextarea(value) {
      this.blockDriver.msg = value;
    },
    blockRequest() {
      this.$store.commit("loaderShow");
      const fd = new FormData();
      fd.append("inform", this.blockDriver.infoStatus);
      fd.append("block_reason", this.blockDriver.msg);
      fd.append("rider_id", this.blockDriver.id);
      this.$refs.close_myModal.click();
      API(this, "admin/block-rider", "post", fd)
        .then((response) => {
          let newArr = this.records.data.filter(
            (x) => x.rider_id != this.blockDriver.id
          );
          this.records.data = newArr;
          this.blockDriver = {
            infoStatus: "none",
            id: null,
            msg: "",
          };
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((error) => {
          console.error(
            "🚀 ~ file: active-deliverers.vue ~ blockRequest ~ error",
            error
          );
          this.$store.commit("loaderHide");
        });
    },
    excludeRecord(id) {
      if (this.excludeID == null && this.excludeID == "") {
        this.$refs.close_myModal1.click();
        this.$store.dispatch("FailToast", {
          message: "Operation cannot completed try again",
        });
        return;
      }
      this.$store.commit("loaderShow");
      const fd = new FormData();
      fd.append("rider_id", id);
      API(this, "admin/exclude-driver", "post", fd)
        .then((response) => {
          let newArr = this.records.data.filter((x) => x.rider_id != id);
          this.records.data = newArr;
          this.$refs.close_myModal1.click();
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((error) => {
          console.error(
            "🚀 ~ file: active-deliverers.vue ~ excludeRecord ~ error",
            error
          );
          this.$store.commit("loaderHide");
        });
    },
    dateTime(value) {
      return moment(value).format("YYYY-MM-DD");
    },
    setBankDetails(value) {
      this.bankDetails = value;
    },
    printTime(dt) {
      return moment(dt).format("HH:mm");
    },
    setRiderHistory(id) {
      this.isHistoryLoading = true;
      API(this, `admin/get-rider-stats/${id}`, "get")
        .then((res) => {
          this.riderHistory = res?.data?.response?.detail;
          this.isHistoryLoading = false;
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: active-deliverers.vue ~ setRiderHistory ~ err",
            err
          );
          this.isHistoryLoading = false;
        });
    },
    printDate(dt) {
      return moment(dt).format("L");
    },
  },
};
</script>

<style lang="scss">
</style>
