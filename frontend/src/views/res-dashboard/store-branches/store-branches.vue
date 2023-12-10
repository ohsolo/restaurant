<template>
  <section>
    <div class="container-fluid">
      <div class="row mt-4 mb-4">
        <div class="col-6">
          <h4 class="sec_hd t_primary fw-bold">
            <span v-if="formTYPE==null">{{ $t("storeBranche.hd1") }}</span>
            <span v-if="formTYPE=='ADD'">{{ $t("storeBranche.hd2") }}</span>
            <span v-if="formTYPE=='EDIT'">{{ $t("storeBranche.hd3") }}</span>
          </h4>
        </div>
        <div class="col-6 text-end">
          <button type="button" class="
              border-0
              bg_primary
              focus_primary
              text-light
              hover_light
              px-3
              py-2
              rounded
            " @click="()=>this.formTYPE='ADD'" v-if="formTYPE==null">
            {{$t("addBtn")}}
          </button>
          <button type="button" class="
              border-0
              bg_primary
              focus_primary
              text-light
              hover_light
              px-3
              py-2
              rounded
            " @click="()=>this.formTYPE=null" v-if="formTYPE!==null">
            {{$t("back")}}
          </button>
        </div>
      </div>
      <!-- ADD FORM -->
      <AddBranchForm v-if="formTYPE == 'ADD'" @my-call-back="clearScreen" />
      <!-- EDIT FORM -->
      <EditBranchForm v-if="formTYPE == 'EDIT'" :itemData="itemData" @my-call-back="clearScreen" />

      <div class="row" v-if="formTYPE == null">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-hover" style="width: 100%; min-width: 1200px">
              <thead>
                <tr>
                  <th class="bg-dark" v-for="x in th" :key="x">
                    <h5 class="text-light fs_1rem text-center pt-2">
                      {{ $t(x) }}
                    </h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="5" v-if="records == ''" class="py-3" align="center">
                    <span>{{ $t("noData") }}</span>
                  </td>
                </tr>
                <tr v-for="data in records" :key="data.branch_id">
                  <td valign="middle">
                    <p class="text-center m_0">{{ data.city.city_name }}</p>
                  </td>
                  <td valign="middle">
                    <p class="text-center m-0">{{ data.location }}</p>
                  </td>
                  <td valign="middle">
                    <p class="text-center m-0">${{ data.value }}</p>
                  </td>
                  <td valign="middle" class="text-center">
                    <div class="">
                      <label class="az_switch">
                        <input type="checkbox" :checked="data.active" @click="statusUpdate(data)" />
                        <span class="slider round"></span>
                      </label>
                      <small class="ms-1 d-inline"
                        :class="data.active ? 'text-success' : 'text-secondary'">Active</small>
                    </div>
                  </td>
                  <td valign="middle" class="text-center">
                    <!-- Edit Branch -->
                    <button type="button" class="btn-primary border-0 px-2 py-1 text-light rounded"
                      @click="editRecord(data)">
                      <fa icon="pen" />
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
      </div>
    </div>
  </section>
</template>

<script>
import { API } from "../../../axois";
import Pagination from "v-pagination-3";
import AddBranchForm from "./add-branch.vue";
import EditBranchForm from "./edit-branch.vue";

export default {
  name: "StoreBranches",
  title: "Store Branches || Dashboard",
  components: { Pagination, AddBranchForm, EditBranchForm },
  data() {
    return {
      page: 1,
      records: "",
      th: [
        "storeBranche.th1",
        "storeBranche.th2",
        "storeBranche.th3",
        "storeBranche.th4",
        "storeBranche.th5",
      ],
      formTYPE: null,
      itemData: null,
    };
  },
  created() {
    this.getRecords();
  },
  methods: {
    // Getting All Branches on Restaurant ID
    getRecords() {
      this.$store.commit("loaderShow");
      let rest = JSON.parse(localStorage.getItem("USER_INFO"));
      var fd = new FormData();
      fd.append("page", this.page);
      fd.append("rest_id", rest.rest_id);
      API(this, "admin/get-branches", "post", fd)
        .then((response) => {
          this.records = response.data.response.detail.data;
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: store-branches.vue ~ getRecords ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
    // Pagination callback
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
    // Update Status
    statusUpdate(data) {
      this.$store.commit("loaderShow");
      let fd = new FormData();
      if (data.active == true) {
        fd.append("status", "false");
      } else {
        fd.append("status", "active");
      }
      API(this, "admin/update-branch/" + data.branch_id, "post", fd)
        .then((response) => {
          this.getRecords();
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((err) => {
          this.$store.commit("loaderHide");
          console.error(
            "🚀 ~ file: store-branches.vue ~ statusUpdate ~ err",
            err
          );
        });
    },
    editRecord(data) {
      this.formTYPE = "EDIT";
      this.itemData = data;
    },
    clearScreen() {
      this.formTYPE = null;
      this.getRecords();
      this.itemData = null;
    },
  },
};
</script>

<style>

</style>