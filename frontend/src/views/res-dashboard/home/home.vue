<template>
  <section class="reports_page">
    <div class="container-fluid">
      <div class="row mb-3" v-if="header">
        <div class="col-6">
          <h4 class="sec_hd t_primary fw-bold">
            {{type=='SHOW_ORDERS'?$t('resHome.hd1'):$t('resHome.hd2')}}
          </h4>
        </div>
        <div class="col-6 text-end">
          <button class="
                border-0
                rounded
                px-4
                py-2
                text-light
                bg_primary
                focus_primary
              " v-if="type=='SHOW_ORDERS'" @click="()=>handleScreen('ADD_ORDER')">
            {{$t('addBtn')}}
          </button>
          <button class="
                border-0
                rounded
                px-4
                py-2
                text-light
                bg_primary
                focus_primary
              " v-if="type=='ADD_ORDER'" @click="()=>handleScreen('SHOW_ORDERS')">
            {{$t('back')}}
          </button>
        </div>
      </div>
      <ShowOrders v-if="type=='SHOW_ORDERS'" />
      <AddOrder v-if="type=='ADD_ORDER'" @handle-screen="handleScreen" />
    </div>
  </section>
</template>

<script>
import AddOrder from './add-order.vue';
import ShowOrders from './show-orders.vue';
export default {
  name: "Home",
  title: "Home | Dashboard",
  components: { AddOrder, ShowOrders },
  data() {
    return {
      type: 'SHOW_ORDERS',
      header: true,
    }
  },
  created() {
  },
  mounted() { },
  methods: {
    handleScreen(t) {
      this.type = t;
    },
  },
};
</script>

