<template>
  <li class="nav_item has-children" v-if="item.childrens">
    <button
      class="border-0 p_relative tb_radius"
      :class="showChildrens === item.id ? 'expanded' : null"
      type="button"
      @click="openChildrens(item.id)"
    >
      <fa :icon="item.icon" />
      <span class="tb_d_none tb_radius">{{ $t("aside." + item.text) }}</span>
      <fa icon="chevron-down" class="chevron tb_d_none" />
    </button>
    <div class="collapse" :class="showChildrens === item.id ? 'show' : null">
      <div class="sub_nav">
        <ul class="pm_0 py-2 list-unstyled">
          <li
            v-for="children in item.childrens"
            :key="children.id"
            class="tb_radius"
          >
            <router-link :to="children.url" class="tb_radius">
              <fa :icon="children.icon" />
              <span class="tb_d_none">{{ $t("aside." + children.text) }}</span>
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </li>
  <li class="nav_item tb_radius" v-else>
    <router-link :to="item.url" class="tb_radius">
      <fa :icon="item.icon" />
      <span class="tb_d_none">{{ $t("aside." + item.text) }}</span>
    </router-link>
  </li>
</template>

<script>
export default {
  name: "NavItem",
  props: {
    item: {
      type: Object,
    },
  },
  data() {
    return {
      showChildrens: 1,
    };
  },
  methods: {
    openChildrens(e) {
      if (this.showChildrens === null || e !== this.showChildrens) {
        this.showChildrens = e;
      } else {
        this.showChildrens = null;
      }
    },
  },
};
</script>

<style></style>
