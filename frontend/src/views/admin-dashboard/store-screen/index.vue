<template>
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 mt-3 mb-4">
          <div class="filter_wrapper mb-5">
            <form class="az_globalForm" @submit.prevent="">
              <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                  <div class="input_wrapper">
                    <div class="loadIcon">
                      <input type="text" class="form-control" v-model="search" />
                      <fa icon="search" />
                    </div>
                  </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                  <div class="d-flex mt_1">
                    <button class="btn w-100 bg_primary text-light focus_primary" @click="searchValue" type="submit">
                      {{ $t("storesPg.searchBtn") }}
                    </button>
                    <button class="btn w-100 ms-2 bg_primary text-light focus_primary" type="button"
                      @click="clearFilter">
                      {{ $t("active_del.clearBtn") }}
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="text-end">
            <router-link to="/company-registration" class="bg_primary focus_primary text-light btn px-5">
            Register Company </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="restaurant_data_table">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-hover table-borderless">
              <thead>
                <tr>
                  <th class="bg-dark text-light" v-for="text in th" :key="text">
                    <h5 class="m_0 pt-3">{{ $t(text) }}</h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td v-if="records.data == '' || !records.data" class="text-center py-4" colspan="7">
                    <span>{{$t('noData')}}</span>
                  </td>
                </tr>
                <tr v-for="data in records.data" :key="data">
                  <td valign="middle">
                    <div class="img_wrapper">
                      <img :src="data.logo_url" alt="" class="img-fluid" />
                    </div>
                  </td>
                  <td valign="middle">
                    <p class="m_0">{{ data.title }}</p>
                  </td>
                  <td valign="middle">
                    <button type="button" class="btn-warning border-0 px-2 py-1 text-light rounded"
                      data-bs-toggle="modal" data-bs-target="#exampleModal3" @click="
                        () => {
                          restProperties = data;
                        }
                      "
                      title="View Details"
                      >
                      <fa icon="eye" />
                    </button>
                  </td>
                  <td valign="middle">
                    <p class="m_0">20</p>
                  </td>
                  <td valign="middle">
                    <p class="m_0">3</p>
                  </td>
                  <td valign="middle">
                    <p class="m_0">{{ data.total_rating }}</p>
                  </td>
                  <td valign="middle">
                    <!-- Visual -->
                    <button type="button" class="
                        btn-warning
                        me-2
                        text-light
                        rounded
                        border-0
                        px-2
                        py-1
                      "
                      title="View"
                      >
                      <fa icon="eye" />
                    </button>
                    <!-- Edit -->
                    <router-link class="
                        btn-primary
                        border-0
                        me-2
                        px-2
                        py-1
                        text-light
                        rounded
                      "
                      :to="{ name: 'EditCompany', params: { id: data.rest_id } }"
                      title="Edit"
                      >
                      <fa icon="pen" />
                    </router-link>
                    <router-link type="button" class="
                        btn-success
                        border-0
                        me-2
                        px-2
                        py-2
                        text-light
                        rounded
                      " :to="{ name: 'Branches', params: { id: data.rest_id } }"
                      title="View Branches"
                      >
                      <fa icon="home" />
                    </router-link>
                    <!-- unblock -->
                    <button type="button" class="
                        btn-secondary
                        text-light
                        border-0
                        me-2
                        px-2
                        py-1
                        rounded
                      " v-if="!data.active" data-bs-toggle="modal" data-bs-target="#exampleModal2" @click="
                        () => {
                          adminRequest.id = data.rest_id;
                          adminRequest.blockStatus = true;
                        }
                      "
                      title="Unlock"
                      >
                      <fa icon="lock-open" />
                    </button>
                    <!-- block -->
                    <button type="button" class="
                        btn-secondary
                        text-light
                        border-0
                        me-2
                        px-2
                        py-1
                        rounded
                      " data-bs-toggle="modal" data-bs-target="#exampleModal2" v-else @click="
                        () => {
                          adminRequest.id = data.rest_id;
                          adminRequest.blockStatus = false;
                        }
                      "
                      title="Lock"
                      >
                      <fa icon="lock" />
                    </button>
                    <!-- delete -->
                    <button type="button" class="btn-danger border-0 px-2 py-1 text-light rounded" @click="
                      () => {
                        excludeID = data.rest_id;
                      }
                    " data-bs-toggle="modal" data-bs-target="#exampleModal1"
                    title="Remove"
                    >
                      <fa icon="times-circle" />
                    </button>
                  </td>
                </tr>
                <!-- <tr>
                  <td colspan="7" valign="middle" class="text-end py-3 pe-5">
                    <router-link to="/store/all-branches" class="bg_primary text-light focus_primary border-0 px-2 py-1 rounded">
                      View All Branches
                    </router-link>
                  </td>
                </tr> -->
              </tbody>
            </table>
          </div>
          <div class="myPagination28 mt-4">
            <pagination v-model="page" :records="records?.total * 1" :per-page="records?.per_page"
              @paginate="paginationCallback($event)" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- exclude Modal -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true"
    ref="close_myModal1">
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
          <h5 class="text-center mb-4">Do you want to delete this record?</h5>
          <div class="text-center">
            <button type="button" data-bs-dismiss="modal" aria-label="Close"
              class="btn-secondary px-2 me-2 py-1 border-0 text-light">
              No
            </button>
            <button type="button" @click="excludeRecord(excludeID)" class="btn-danger px-2 py-1 border-0 text-light">
              Yes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Block / Unblock Records -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true"
    ref="close_myModal2">
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
          <form action="" class="" @submit.prevent="blockRequest" v-if="!adminRequest.blockStatus">
            <div class="row">
              <div class="col-12">
                <div class="input_wrapper">
                  <label for="rd-btn1">
                    <input type="radio" class="form-check-input me-1" name="reason" id="rd-btn1"
                      :checked="adminRequest.infoStatus == 'none'" value="none"
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
                      :checked="adminRequest.infoStatus == 'yes'" value="yes"
                      @change="handleModalRdBtn($event.target.value)" />
                    Yes
                  </label>
                </div>
              </div>
            </div>
            <div class="row mt-4" v-if="adminRequest.infoStatus != 'none'">
              <div class="col-12">
                <div class="input_wrapper">
                  <textarea name="" id="" class="form-control" cols="30" rows="3" :value="adminRequest.msg"
                    :required="adminRequest.infoStatus == 'yes'" placeholder="Descreva or reason"
                    @change="handleTextarea($event)"></textarea>
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
          <form action="" class="" @submit.prevent="blockRequest" v-else>
            <div class="row mt-4">
              <div class="col-12">
                <div class="input_wrapper">
                  <textarea name="" id="" class="form-control" cols="30" rows="3" :value="adminRequest.msg" required
                    placeholder="Descreva or reason" @change="handleTextarea($event)"></textarea>
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
  <!-- delivery tax Modal -->
  <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModal3Label" aria-hidden="true"
    ref="close_myModal3">
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
          <h5 class="text-center mb-4">Definition of delivery tax</h5>
          <form action="" class="az_globalForm" autocomplete="off" @submit.prevent="SubmitDeliveryTaxForm">
            <div class="input_wrapper">
              <label for="rdBtn22" class="d-flex align-items-center flex-wrap">
                <input type="radio" name="tax" :checked="restProperties?.tax_by_distance" class="form-check-input me-2"
                  id="rdBtn22" value="tax_by_distance" ref="myRdBtn1" />
                <!-- @click="handleRadioBtn($event)" -->
                <small>Taxes by distance (Value per km defined by the
                  platform)</small>
              </label>
            </div>
            <div class="input_wrapper mt-2">
              <label for="rdBtn23" class="d-flex align-items-center flex-wrap">
                <input type="radio" name="tax" :checked="restProperties?.custom_tax" class="form-check-input me-2"
                  value="custom_tax" id="rdBtn23" ref="myRdBtn2" />
                <small>Custom taxes by neighborhood</small>
              </label>
            </div>
            <div class="input_wrapper mt-2">
              <label for="chBtn" class="d-flex align-items-center flex-wrap">
                <input type="checkbox" name="" :checked="restProperties?.mirror_tax" class="form-check-input me-2"
                  id="chBtn" ref="myCheckbox" />
                <small>Mirror taxa of the main system</small>
              </label>
            </div>
            <div class="mt-5 text-center">
              <button type="button" data-bs-dismiss="modal" class="btn px-5 text-light btn-secondary"
                ref="close_myModal">
                Close
              </button>
              <input type="submit" class="ms-3 px-5 btn focus_primary text-light bg_primary" value="Send" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { API } from "../../../axois";
import SearchContent from "../../../components/admin-components/search-content/index.vue";
// import SearchContent2 from "./search-content2.vue";
import Pagination from "v-pagination-3";
export default {
  name: "Store",
  title: "Store | Dashboard",
  components: { Pagination, SearchContent },
  data() {
    return {
      records: [],
      page: 1,
      search: "",
      excludeID: null,
      restProperties: null,
      adminRequest: {
        infoStatus: "none",
        id: null,
        msg: "",
        blockStatus: null,
      },
      th: ['storesPg.th1', '', 'storesPg.th2', 'storesPg.th3', 'storesPg.th4', 'storesPg.th5', 'storesPg.th6'],
    };
  },
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      const fd = new FormData();
      fd.append("page", this.page);
      if (this.search != null && this.search != "") {
        fd.append("search", this.search);
      }
      API(this, "admin/all-rests", "post", fd)
        .then((response) => {
          this.$store.commit("loaderHide");
          this.records = response.data.response.detail;
        })
        .catch((err) => {
          console.error("🚀 ~ file: index.vue ~ getRecords ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
    clearFilter() {
      this.search = null;
      this.getRecords();
    },
    searchValue() {
      if (this.search != null && this.search != "") {
        this.page = 1;
        this.getRecords();
      }
    },
    handleModalRdBtn(value) {
      this.adminRequest.infoStatus = value;
    },
    handleTextarea(event) {
      this.adminRequest.msg = event.target.value;
    },
    blockRequest() {
      this.$store.commit("loaderShow");
      const fd = new FormData();
      var apiStr;

      if (this.adminRequest.blockStatus) {
        apiStr = "admin/unblock-restaurants";
        fd.append("approve_reason", this.adminRequest.msg);
        fd.append("rest_id", this.adminRequest.id);
      } else {
        apiStr = "admin/block-restaurant";
        fd.append("inform", this.adminRequest.infoStatus);
        if (this.adminRequest.infoStatus == "yes") {
          fd.append("block_reason", this.adminRequest.msg);
        }
        fd.append("rest_id", this.adminRequest.id);
      }

      this.$refs.close_myModal2.click();
      API(this, apiStr, "post", fd)
        .then((response) => {
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
          let objIndex = this.records.data.findIndex(
            (x) => (x.rest_id == this.adminRequest.id)
          );
          if (this.adminRequest.blockStatus) {
            this.records.data[objIndex].active = true;
          } else {
            this.records.data[objIndex].active = false;
          }
          this.adminRequest = {
            infoStatus: "none",
            id: null,
            msg: "",
            blockStatus: null,
          };
          this.$store.commit("loaderHide");
        })
        .catch((error) => {
          console.error("🚀 ~ file: index.vue ~ blockRequest ~ error", error)
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
      fd.append("rest_id", id);
      API(this, "admin/delete-restaurant", "post", fd)
        .then((response) => {
          let newArr = this.records.data.filter((x) => x.rest_id != id);
          this.records.data = newArr;
          this.$store.commit("loaderHide");
          this.$refs.close_myModal1.click();
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((error) => {
          console.error("🚀 ~ file: index.vue ~ excludeRecord ~ error", error)
          this.$store.commit("loaderHide");
        });
    },
    handleRadioBtn(event) {
      if (event.target.value == "tax_by_distance") {
        this.deliveryTaxForm.radiobtn1 = 1;
        this.deliveryTaxForm.radiobtn2 = 0;
      } else {
        this.deliveryTaxForm.radiobtn1 = 0;
        this.deliveryTaxForm.radiobtn2 = 1;
      }
    },
    SubmitDeliveryTaxForm() {
      this.$store.commit("loaderShow");
      let fd = new FormData();
      var value1, value2, value3;
      value1 = this.$refs.myRdBtn1.checked ? 1 : 0;
      value2 = this.$refs.myRdBtn2.checked ? 1 : 0;
      value3 = this.$refs.myCheckbox.checked ? 1 : 0;

      fd.append("tax_by_distance", value1);
      fd.append("custom_tax", value2);
      fd.append("mirror_tax", value3);
      API(
        this,
        "admin/update-restaurant-props/" + this.restProperties.rest_id,
        "post",
        fd
      )
        .then((response) => {
          this.$store.commit("loaderHide");
          this.$refs.close_myModal3.click();
          let objIndex = this.records.data.findIndex(
            (x) => x.rest_id == this.restProperties.rest_id
          );
          this.records.data[objIndex] =
            response.data.response.detail.restaurant;
          this.restProperties = null;
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((err) => {
          console.error("🚀 ~ file: index.vue ~ SubmitDeliveryTaxForm ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
  },
};
</script>

<style lang="scss" scoped>

</style>
