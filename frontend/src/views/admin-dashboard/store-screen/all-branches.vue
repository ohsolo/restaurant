<template>
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">All Branches</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="bg-dark" v-for="x in th" :key="x">
                    <h5 class="text-light fs_1rem text-center pt-2">{{ x }}</h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="5" class="py-3" align="center">
                    <span>Data Not Found</span>
                  </td>
                </tr>
                <tr>
                  <td valign="middle">
                    <p class="text-center m_0">Sindh</p>
                  </td>
                  <td valign="middle">
                    <p class="text-center m-0">Bolochistan</p>
                  </td>
                  <td valign="middle">
                    <p class="text-center m-0">Rs$5.00</p>
                  </td>
                  <td valign="middle" class="text-center">
                    <div class="">
                      <label class="az_switch">
                        <input type="checkbox" />
                        <span class="slider round"></span>
                      </label>
                      <small class="ms-1 d-inline" :class="
                        'red' == 'ggg' ? 'text-success' : 'text-secondary'
                      ">Active</small>
                    </div>
                  </td>
                  <td valign="middle" class="text-center">
                    <!-- delete -->
                    <button type="button" class="btn-danger border-0 px-2 py-1 text-light rounded">
                      <fa icon="times-circle" />
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
export default {
  name: "AllBranches",
  title: "All Branches || Dashboard",
  components: { Pagination },
  data() {
    return {
      page: 1,
      records: "",
      th: ["City", "Neighborhood", "Value", "Status", "Action"],
    };
  },
  mounted() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      var fd = new FormData();
      fd.append("page", this.page);
      fd.append("rest_id", this.$route.params.id);
      API(this, "admin/get-branches", "post", fd)
        .then((response) => {
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: all-branches.vue ~ getRecords ~ err", err)
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