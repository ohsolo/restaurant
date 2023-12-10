<template>
  <div class="az_awaiting_approval">
    <section class="riderOcc">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h4 class="sec_hd t_primary fw-bold">
              {{ $t("rider_occ_del.hd1") }}
            </h4>
          </div>
        </div>
        <div class="row">
          <div v-if="records?.data == ''" class="mt-4">
            <h6 class="text-center" style="color: #ff6400">
              {{ $t("rider_occ_del.msg1") }}
            </h6>
          </div>
          <div class="col-md-6 mt-4" v-for="data in records?.data" :key="data.id">
            <div class="occ_card shadow p-3 d-flex" style="border-radius: 14px">
              <div class="az_left me-3">
                <div class="img_wrapper bg-light" style="
                    width: 100px;
                    height: 100px;
                    overflow: hidden;
                    border-radius: 100%;
                  ">
                  <img :src="data.rider.profile_image_url" class="w-100 h-100" />
                </div>
              </div>
              <div class="az_right pt-3 pb-2" style="flex: 1">
                <div class="d-flex justify-content-between" style="font-size: 12px; color: #ff6400">
                  <p class="occ_cret mb-0">
                    {{ data.created_at.slice(0, 10) }} ,
                    {{ data.created_at.slice(11, 16) }}
                  </p>
                  <span>Order # {{ data.order.order_number }}</span>
                </div>
                <p class="occ_res mb-1">
                  {{ data.reason }}
                </p>
                <!-- <small class="occ_q text-secondary" style="font-size: 10px"
                >you wanted to assume</small
              > -->
              </div>
            </div>
          </div>
        </div>
        <div class="myPagination28 mt-4">
          <pagination v-model="page" :records="records?.total * 1" :per-page="records?.per_page"
            @paginate="paginationCallback($event)" />
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { API } from "../../../axois.js";
import Pagination from "v-pagination-3";
export default {
  name: "RiderOccurences",
  title: "Occurrences | Dashbaord",
  components: { Pagination },
  data() {
    return {
      page: 1,
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
      API(this, "admin/get-occurrences/" + this.$route.params.id, "post", fd)
        .then((response) => {
          const Data = response.data.response.detail.restaurant_occurrence;
          this.records = Data;
          this.$store.commit("loaderHide");
        })
        .catch((error) => {
          console.error("🚀 ~ file: rider-occurence.vue ~ getRecords ~ error", error)
          this.$store.commit("loaderHide");
        });
    },
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
  },
};
</script>

<style>

</style>