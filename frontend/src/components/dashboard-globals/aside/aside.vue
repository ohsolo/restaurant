<template>
  <aside
    :class="[
      this.$store.state.primaryNav ? 'open' : null,
      this.$store.getters.shrink ? 'shrink' : '',
    ]"
  >
    <div class="az_aside_wrapper p_relative">
      <div class="p_relative">
        <button
          type="button border-0"
          @click="closeMenu"
          class="close_primary_nav"
        >
          <fa icon="times" />
        </button>
      </div>
      <div class="navBar_brand">
        <div class="logo_wrapper">
          <img src="../../../assets/images/logo.png" alt="" class="img-fluid" />
        </div>
        <button
          type="button border-0"
          @click="toggle_btn"
          class="toggle_lg_btn"
        >
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
      <ul class="pm_0 list-unstyled tb_flex">
        <NavItem :item="item" v-for="item in items" :key="item.id" />
      </ul>
      <div class="logout_btn_wrapper">
        <button @click="logOut">
          <fa icon="arrow-right-from-bracket" />
          <span class="tb_d_none ms-2">{{ $t("lgOut") }}</span>
        </button>
      </div>
    </div>
  </aside>
</template>

<script>
import NavItem from "./navItem.vue";
export default {
  name: "Aside",
  components: {
    NavItem,
  },
  props: {
    items: {
      type: Object,
    },
    log_out:{
      type: Function,
    }
  },
  data() {
    return {
      isShrink: false,
      currentPath: null,
    };
  },
  methods: {
    closeMenu() {
      this.$store.commit("togglePrimaryNav", false);
    },
    toggle_btn() {
      this.isShrink = !this.isShrink;
      this.$store.commit("isMenuShrink", !this.isShrink);
    },
    logOut() {
      this.$emit('log_out');
    },
  },
};
</script>

<style></style>
