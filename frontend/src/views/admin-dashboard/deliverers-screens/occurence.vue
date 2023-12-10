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
                    <input type="text" class="form-control" v-model="search"
                      placeholder="Search by name, e-mail, tel. or CPF No." />
                    <fa icon="search" />
                  </div>
                </div>
                <div>
                  <button class="btn w-100 bg_primary text-light focus_primary" @click="searchValue" type="button">
                    {{ $t("occurr_del.searchBtn") }}
                  </button>
                </div>
              </div>
              <div class="d-flex">
                <div class="input_wrapper">
                  <label for="" class="fs_small mb-1">
                    {{ $t("occurr_del.label1") }}
                  </label>
                  <SearchContent url="admin/get-regions-by-name?search=" givenValue="Select Region" objKey="regions"
                    myKey="title" @my-call-back="myCallBack" />
                </div>
                <div class="input_wrapper">
                  <label for="" class="fs_small mb-1">
                    {{ $t("occurr_del.label2") }}
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
                    {{ $t("occurr_del.clearBtn") }}
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
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th1") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th2") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th3") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th4") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th5") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th6") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th7") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th8") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th10") }}</h5>
                </th>
                <th class="bg-dark text-light">
                  <h5 class="m_0 text-center">{{ $t("occurr_del.th11") }}</h5>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td v-if="records?.data == ''" colspan="11" class="text-center">
                  <span>{{ $t("occurr_del.notFound") }}</span>
                </td>
              </tr>
              <tr v-for="data in records?.data" :key="data.id">
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
                  <router-link :to="{ name: 'RiderOccurences', params: { id: data.rider_id } }" type="button" class="
                      border-0
                      btn-warning
                      py-1
                      text-light
                      rounded
                      px-2
                      me-1
                    ">
                    <fa icon="eye" />
                  </router-link>
                  <button type="button" class="border-0 bg-danger text-light rounded py-1 px-2" data-bs-toggle="modal"
                    data-bs-target="#exampleModal3" @click="
                      () => {
                        blockDriver.id = data.rider_id;
                      }
                    ">
                    <fa icon="lock" />
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

  <!-- MYMODAL 3 -->
  <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModal3Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn ms-auto d-block focus_primary fs-4" style="line-height: 0"
                data-bs-dismiss="modal" aria-label="Close">
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
                    <input type="radio" class="form-check-input me-1" name="reason" id="rd-btn1"
                      :checked="blockDriver.infoStatus == 'none'" value="none"
                      @change="handleModalRdBtn($event.target.value)" />
                    None
                  </label>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12">
                <div class="input_wrapper">
                  <label for="rd-btn2">
                    <input type="radio" class="form-check-input me-1" name="reason" id="rd-btn2"
                      :checked="blockDriver.infoStatus == 'yes'" value="yes"
                      @change="handleModalRdBtn($event.target.value)" />
                    Yes
                  </label>
                </div>
              </div>
            </div>
            <div class="row mt-4" v-if="blockDriver.infoStatus != 'none'">
              <div class="col-12">
                <div class="input_wrapper">
                  <textarea name="" id="" class="form-control" cols="30" rows="3" :value="blockDriver.msg"
                    :required="blockDriver.infoStatus == 'yes'" placeholder="Descreva or reason"
                    @change="handleTextarea($event.target.value)"></textarea>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 text-center">
                <button type="button" data-bs-dismiss="modal" class="btn px-5 text-light btn-secondary"
                  ref="close_myModal">
                  Close
                </button>
                <input type="submit" class="ms-3 px-5 btn focus_primary text-light bg_primary" value="Send" />
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
import moment from "moment";
import Pagination from "v-pagination-3";
import SearchContent from "../../../components/admin-components/search-content/index.vue";
export default {
  name: "AwaitingApproval",
  title: "Occurrences | Dashbaord",
  components: { Pagination, SearchContent },
  data() {
    return {
      page: 1,
      search: null,
      regionData: [],
      blockDriver: {
        infoStatus: "none",
        id: null,
        msg: "",
      },
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
      selectedRanking: "All",
      records: null,
      bankDetails: null,
    };
  },
  mounted() {
    API(this, "admin/check-token", "get", null)
      .then((res) => { })
      .catch((err) => {
        this.initFirebaseMessagingRegistration();
      });
  },
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      const fd = new FormData();
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
      API(this, "admin/get-restaurant-occurrences", "get")
        .then((response) => {
          const Data = response.data.response.detail.rider_occurences;
          this.records = Data;
          this.$store.commit("loaderHide");
        })
        .catch((error) => {
          console.error("🚀 ~ file: occurence.vue ~ getRecords ~ error", error)
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
      (this.search = null), (this.selectedVehicle = "All");
      this.selectedRegion = "Every where";
      this.getRecords();
    },
    handleModalRdBtn(value) {
      this.blockDriver.infoStatus = value;
    },
    dateTime(value) {
      return moment(value).format("YYYY-MM-DD");
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
          console.error("🚀 ~ file: occurence.vue ~ blockRequest ~ error", error)
          this.$store.commit("loaderHide");
        });
    },
    initFirebaseMessagingRegistration() {
      this.$Messaging
        .requestPermission()
        .then(() => {
          return this.$Messaging.getToken({
            vapidKey: this.$WebPC,
          });
        })
        .then(function (token) {
          API(this, "admin/save-pn-token", "post", { token: token })
            .then((res) => { })
            .catch((err) => { });
        })
        .catch(function (err) { });
    },
    myCallBack(item) { },
  },
};
</script>

<style lang="scss">

</style>
