<template>
  <section class="reports_page">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold">Rider Details</h4>
        </div>
      </div>
    </div>
  </section>
</template>
    
<script>
import { API } from "../../../axois.js";
import Pagination from "v-pagination-3";

export default {
  name: "RiderDetails",
  components: { Pagination },
  data() {
    return {
      records: null,
      page: 1,
    };
  },
  created() {
    this.getRecords();
  },
  mounted() {},
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      API(this, `admin/get-rider-stats/${this.$route.params.id}`, "get", )
        .then((res) => {
          this.records = res?.data?.response?.detail;
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: rider-details.vue ~ getRecords ~ err", err);
          this.$store.commit("loaderHide");
        });
    },
    // Pagination callback
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
  },
};
</script>
    
    