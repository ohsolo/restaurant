<template>
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">{{$t ("storeBranche.hd1")}}</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-hover" style="width: 100%; min-width: 1200px">
              <thead>
                <tr>
                  <th class="bg-dark" v-for="x in th" :key="x">
                    <h5 class="text-light fs_1rem text-center pt-2">{{ $t(x) }}</h5>
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
                    <p class="text-center m_0">{{data.city.city_name}}</p>
                  </td>
                  <td valign="middle">
                    <p class="text-center m-0">{{ data.location }}</p>
                  </td>
                  <td valign="middle">
                    <p class="text-center m-0">Rs${{ data.value }}</p>
                  </td>
                  <td valign="middle" class="text-center">
                    <div class="">
                      <fa icon="check" class="text-success" v-if="data.active" />
                      <fa icon="times" class="text-secondary" v-else />
                    </div>
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
export default {
  name: "Branches",
  title: "Store Branches || Dashboard",
  components: { Pagination },
  data() {
    return {
      page: 1,
      records: "",
      th: ["storeBranche.th1", "storeBranche.th2", "storeBranche.th3", "storeBranche.th4"],
    };
  },
  mounted() {
    this.getRecords();
  },
  methods: {
    // Getting All Branches on Restaurant ID
    getRecords() {
      this.$store.commit("loaderShow");
      var fd = new FormData();
      fd.append("page", this.page);
      fd.append("rest_id", this.$route.params.id);
      API(this, "admin/get-branches", "post", fd)
        .then((response) => {
          this.records = response.data.response.detail.data;
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: branches.vue ~ getRecords ~ err", err)
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

<style lang="scss">

</style>