<template>
  <footer class="az_footerp00">
    <div class="d-flex align-items-center flex-wrap justify-content-center">
      <div class="icon_wrapper">
        <fa icon="hotel" />
      </div>
      <p class="copyright m_0">
        {{ year }} &copy;
        <span class="t_primary">Litoral Na Mesa Deliverer</span>
      </p>
      <div class="foo_link_wrapper">
        <router-link to="/#">{{ $t("foo.tUse") }}</router-link>
        <router-link to="/#"> {{ $t("foo.support") }}</router-link>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "Footer",
  data() {
    return {
      year: new Date().getFullYear(),
    };
  },
};
</script>

<style lang="scss" scoped></style>
