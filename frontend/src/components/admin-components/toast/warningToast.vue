<template>
  <div class="az_toast warning rounded d-flex align-items-center">
      <fa icon="exclamation-triangle" class="text-light me-2"/>
      <h5 class="m_0 t_primary">{{this.$store.state.toast.warningMsg}}</h5>
  </div>
</template>

<script>
export default {
    name:"WarningToast",
    mounted(){
    }
}
</script>

<style lang="scss">

</style>