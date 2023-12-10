<template>
  <section class="reports_page">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-6">
          <h4 class="sec_hd t_primary fw-bold">
            {{ $t("adminHome.hd1") }}
          </h4>
        </div>
      </div>
      <ShowOrders v-if="type == 'SHOW_ORDERS'" />
    </div>
  </section>
</template>

<script>
import ShowOrders from "./show-orders.vue";
export default {
  name: "Home",
  title: "Home | Dashboard",
  components: { ShowOrders },
  data() {
    return {
      type: "SHOW_ORDERS",
    };
  },
  created() {},
  mounted() {},
  methods: {
    handleScreen(t) {
      this.type = t;
    },
  },
};
</script>

