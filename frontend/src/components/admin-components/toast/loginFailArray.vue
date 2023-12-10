<template>
    <div class="az_toast fail rounded d-flex align-items-center">
        <fa icon="exclamation-triangle" class="text-light me-2" />
        <h5 class="m_0 t_primary"><small v-if="email">{{email}}</small> <small v-if="password">{{password}}</small></h5>
    </div>
</template>

<script>
export default {
    name: "LoginFailToastArray",
    data() {
        return {
            email: this.$store.state.toast.loginFailToastArrayText.email[0],
            password: this.$store.state.toast.loginFailToastArrayText.password[0],
        }
    },
}
</script>
