<template>
  <div
    class="az_toast fail rounded d-flex align-items-center"
    v-for="msg in this.$store.state.toast.failMsg"
    :key="msg"
  >
    <fa icon="exclamation-triangle" class="text-light me-2" />
    <h5 class="m_0 t_primary">{{ msg }}</h5>
  </div>
</template>

<script>
export default {
  name: "FailToast",
  data() {
    return {};
  },
  mounted() {},
};
</script>

<style lang="scss"></style>
