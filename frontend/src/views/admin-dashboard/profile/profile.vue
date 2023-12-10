<template>
  <section class="profile_page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold">Profile</h4>
        </div>
        <div class="d-flex align-items-center justify-content-center py-5" v-if="user == null">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div class="row mt-4 justify-content-center" v-if="user !== null">
        <div class="col-4">
          <div class="card">
            <div class="card-header py-4 px-3">
              <div class="text-center">
                <fa icon="user" width="45" height="45" class="t_primary img-fluid" />
              </div>
            </div>
            <div class="card-body py-4 px-3">
              <table class="table">
                <tbody>
                  <tr>
                    <td class="text-start">Name</td>
                    <td class="text-end">{{ user.name }}</td>
                  </tr>
                  <tr>
                    <td class="text-start">Email</td>
                    <td class="text-end">{{ user.email }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <form action="">
        <div class="row mt-5">
          <div class="col-12">
            <h4 class="sec_hd t_primary fw-bold">Change Password</h4>
          </div>
          <div class="col-6 mt-4">
            <div class="input_wrapper">
              <label class="mb-2">Password</label>
              <div class="p_relative">
                <input type="password" class="form-control" id="" required />
              </div>
            </div>
          </div>
          <div class="col-6 mt-4">
            <div class="input_wrapper">
              <label class="mb-2">Confirm Password</label>
              <div class="p_relative">
                <input type="password" class="form-control" id="" required />
              </div>
            </div>
          </div>
          <div class="col-12 mt-5 text-end">
            <input type="submit" class="
                btn
                bg_primary
                focus_primary
                hover_light
                text-light
                px-4
              " value="Submit" />
          </div>
        </div>
      </form>
    </div>
  </section>
</template>
  
<script>
import { API } from "../../../axois.js";
export default {
  name: "AdminProfile",
  title: "Profile | Dashboard",
  data() {
    return {
      user: null,
    };
  },
  created() {
    this.user = this.$store.state.admin;
  },
  mounted() { },
  methods: {},
};
</script>
  
  