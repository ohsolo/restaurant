<template>
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-6">
          <h4 class="sec_hd t_primary fw-bold">
            {{ type == "SHOW_ADDRESSES" ? $t("addr.hd1") : $t("addr.hd2") }}
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
            " @click="() => type = 'ADD_ADDRESS'" v-if="type == 'SHOW_ADDRESSES'">
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
            " @click="() => type = 'SHOW_ADDRESSES'" v-if="type == 'ADD_ADDRESS'">
            {{$t("back")}}
          </button>
        </div>
      </div>
      <AddAddress v-if="type == 'ADD_ADDRESS'" />
      <ShowAddresses v-if="type == 'SHOW_ADDRESSES'" />
    </div>
  </section>
</template>

<script>
import AddAddress from "./add-address.vue";
import ShowAddresses from "./show-adresses.vue";

export default {
  name: "Addresses",
  title: "Addresses | Dashboard",
  components: { AddAddress, ShowAddresses },
  data() {
    return {
      type: "SHOW_ADDRESSES",
    };
  },
  created() { },
  methods: {},
};
</script>
