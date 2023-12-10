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
                  <button class="btn w-100 bg_primary text-light focus_primary" @click="searchValue" type="button">
                    {{ $t("active_del.searchBtn") }}
                  </button>
                </div>
              </div>
              <div class="d-flex">
                <div class="input_wrapper">
                  <label for="" class="fs_small mb-1">
                    {{ $t("active_del.label1") }}
                  </label>
                  <select class="form-select" @change="filterRegion()" v-model="selectedRegion">
                    <option selected>Every where</option>
                    <option v-for="item in regionData" :key="item.region_id" :value="item.region_id">
                      {{ item.title }}
                    </option>
                  </select>
                </div>
                <div class="input_wrapper">
                  <label for="" class="fs_small mb-1">
                    {{ $t("active_del.label2") }}
                  </label>
                  <select class="form-select" @change="filterVehicle()" v-model="selectedVehicle">
                    <option selected>All</option>
                    <option v-for="item in vehicle" :key="item" :value="item.value">
                      {{ item.text }}
                    </option>
                  </select>
                </div>
                <div>
                  <button class="btn w-100 bg_primary text-light focus_primary" type="button" @click="clearFilter">
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
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th1") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th2") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th3") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th4") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th5") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th6") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th7") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th8") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th9") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th10") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("active_del.th11") }}</h5>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td v-if="records?.data == ''" colspan="11" class="text-center">
                  <span>{{ $t("active_del.notFound") }}</span>
                </td>
              </tr>
              <tr v-for="data in records?.data" :key="data">
                <td>
                  <p class="m_0 text-center">{{ data.name }}</p>
                </td>
                <td class="text-center">
                  <fa class="t_primary" v-if="data.vehicle_type == 'car'" icon="car" />
                  <fa class="t_primary" v-if="data.vehicle_type == 'bike'" icon="motorcycle" />
                  <fa class="t_primary" v-if="data.vehicle_type == 'bicycle'" icon="bicycle" />
                </td>
                <td>
                  <p class="m_0 text-center">{{ data.cpf }}</p>
                </td>
                <td class="text-center">
                  <a class="border-0 btn-warning py-1 text-light rounded px-2" :href="data.profile_image_url"
                    target="_blank" rel="noopener">
                    <fa icon="eye" />
                  </a>
                </td>
                <td class="text-center">
                  <a class="border-0 btn-warning py-1 text-light rounded px-2" :href="data.cnh_image_url"
                    target="_blank" rel="noopener">
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
                <td class="text-center">{{ dateTime(data.created_at) }}</td>
                <td class="text-center">
                  <button class="me-1 bg-secondary text-light border-0 rounded py-1 px-2" type="button"
                    data-bs-toggle="modal" data-bs-target="#exampleModal2" @click="
                      () => {
                        blockReason = data.block_reason;
                        blockDT = data.block_date;
                      }
                    ">
                    Details
                  </button>
                </td>
                <td class="text-center">
                  <button type="button"
                    class="border-0 bg_primary focus_primary text-light text-center rounded py-1 px-2"
                    @click="unblockDriver(data.rider_id)">
                    <fa icon="lock-open" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="myPagination28 mt-4">
          <pagination v-model="page" :records="records?.total * 1" :per-page="records?.per_page"
            @paginate="paginationCallback($event)" />
        </div>
      </div>
    </section>
  </div>
  <!-- Modal 1 -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn ms-auto d-block focus_primary fs-4" style="line-height: 0"
                data-bs-dismiss="modal" aria-label="Close">
                <fa icon="times" class="t_primary" />
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h5 class="text-center t_primary fw-bold" style="margin-top: -15px">
                Block Reason
              </h5>
              <hr />
            </div>
          </div>
          <div class="row">
            <div class="col-12 px-4">
              <p class="mb-2">
                <small class="mb-1 d-block"><b>Block Date : </b> {{ blockDT }}</small>
                <span v-if="blockReason != '' || blockReason == null">
                  <b>Reason : </b>{{ blockReason }}
                </span>
                <span v-else><b>Reason : </b>No reason has been given by admin
                </span>
              </p>
            </div>
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
  name: "BlockedDeliverers",
  title: "Riders Blocked Deliverers | Dashbaord",
  components: { Pagination },
  data() {
    return {
      page: 1,
      blockDT: "",
      blockReason: "",
      search: null,
      regionData: [],
      selectedRegion: "Every where",
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
    };
  },
  mounted() { },
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      const fd = new FormData();
      fd.append("status", "blocked");
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
          this.$store.commit("loaderHide");
          console.error("🚀 ~ file: blocked-deliverers.vue ~ getRecords ~ error", error)
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
    unblockDriver(id) {
      this.$store.commit("loaderShow");
      const fd = new FormData();
      fd.append("rider_id", id);
      API(this, "admin/unblock-rider", "post", fd)
        .then((response) => {
          let newArr = this.records.data.filter((x) => x.rider_id != id);
          this.records.data = newArr;
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((error) => {
          this.$store.commit("loaderHide");
          console.error("🚀 ~ file: blocked-deliverers.vue ~ unblockDriver ~ error", error)
        });
    },
    dateTime(value) {
      return moment(value).format("YYYY-MM-DD");
    },
    setBankDetails(value) {
      this.bankDetails = value;
    },
  },
};
</script>

<style lang="scss">

</style>
