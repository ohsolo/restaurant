<template>
  <div class="az_toast success rounded d-flex align-items-center">
      <fa icon="check" class="text-light me-2"/>
      <h5 class="m_0 t_primary">{{this.$store.state.toast.successMsg}}</h5>
  </div>
</template>

<script>
export default {
    name:"SuccessToast",
    mounted(){
    }
}
</script>

<style lang="scss">

</style>