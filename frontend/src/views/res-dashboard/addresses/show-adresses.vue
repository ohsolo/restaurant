<template>
  <div class="row mt-5">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-hover" style="width: 100%; min-width: 450px">
          <thead>
            <tr>
              <th class="bg-dark">
                <h5 class="text-light pt-2">{{$t("addr.th1")}}</h5>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td v-if="!records?.data.length" class="py-3" align="center">
                <span class="text-secondary">{{ $t("noData") }}</span>
              </td>
            </tr>
            <tr v-for="item in records?.data" :key="item?.id">
              <td>
                <p class="m_0">{{item.location}}</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
  
<script>
import { API } from "../../../axois.js";

export default {
  name: "ShowAddresses",
  title: "Addresses | Dashboard",
  data() {
    return {
      records: null,
      page: 1
    };
  },
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      var fd = new FormData();
      fd.append("page", this.page);
      API(this, "rest/get-all-addresses", "get", fd)
        .then((res) => {
          this.records = res?.data?.response?.detail.addresses;
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: show-adresses.vue ~ getRecords ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
  },
};
</script>
  