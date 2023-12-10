<template>
  <section class="profile_page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold">{{ $t('profile') }}</h4>
        </div>
        <div
          class="d-flex align-items-center justify-content-center py-5"
          v-if="user == null"
        >
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div class="row mt-4 justify-content-center" v-if="user !== null">
        <div class="col-12">
          <div class="card mx-auto" style="max-width:450px">
            <div class="card-header py-4 px-3">
              <div class="text-center">
                <img :src="user.logo_url" alt="" width="75" class="img-fluid" />
                <p class="mt-2">{{ user.title }}</p>
              </div>
            </div>
            <div class="card-body py-4 px-3">
              <table class="table">
                <tbody>
                  <tr>
                    <td class="text-start">{{ $t("resPro.Active") }}</td>
                    <td class="text-end">
                      <fa
                        icon="circle"
                        class="text-success"
                        v-if="user.active"
                      />
                      <fa icon="circle" class="text-danger" v-else />
                    </td>
                  </tr>
                  <tr>
                    <td class="text-start">{{ $t("resPro.Rating") }}</td>
                    <td class="text-end">{{ user.total_rating }}</td>
                  </tr>
                  <tr>
                    <td class="text-start">{{ $t("resPro.Email") }}</td>
                    <td class="text-end">{{ user.email }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12 redesign_tabs">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item me-2" role="presentation">
              <button
                class="nav-link active"
                id="pills-home-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-home"
                type="button"
                role="tab"
                aria-controls="pills-home"
                aria-selected="true"
              >
              {{ $t("resPro.Company_Data") }}
              </button>
            </li>
            <li class="nav-item me-2" role="presentation">
              <button
                class="nav-link"
                id="pills-profile-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-profile"
                type="button"
                role="tab"
                aria-controls="pills-profile"
                aria-selected="false"
              >
              {{ $t("resPro.Bank_Data") }}
              </button>
            </li>
            <li class="nav-item me-2" role="presentation">
              <button
                class="nav-link"
                id="pills-contact-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-contact"
                type="button"
                role="tab"
                aria-controls="pills-contact"
                aria-selected="false"
              >
              {{ $t("resPro.Change_Password") }}
              </button>
            </li>
          </ul>
        </div>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div
          class="tab-pane fade show active"
          id="pills-home"
          role="tabpanel"
          aria-labelledby="pills-home-tab"
        >
          <!-- Profile Data -->
          <form action="">
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.Phone_Number") }}</label>
                  <div class="p_relative">
                    <input type="text" class="form-control" id="" required />
                  </div>
                </div>
              </div>
              <div class="col-12 mt-5 text-end">
                <input
                  type="submit"
                  class="
                    btn
                    bg_primary
                    focus_primary
                    hover_light
                    text-light
                    px-4
                  "
                  :value="$t('submitBtn')"
                />
              </div>
            </div>
          </form>
        </div>
        <div
          class="tab-pane fade"
          id="pills-profile"
          role="tabpanel"
          aria-labelledby="pills-profile-tab"
        >
          <!-- Bank Data -->
          <form action="">
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.Bank") }}</label>
                  <div class="p_relative">
                    <input type="text" class="form-control" id="" required />
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.Agency") }}</label>
                  <div class="p_relative">
                    <input type="text" class="form-control" id="" required />
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.Agency_Verification_Code") }}</label>
                  <div class="p_relative">
                    <input
                      type="password"
                      class="form-control"
                      id=""
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.Account") }}</label>
                  <div class="p_relative">
                    <input
                      type="password"
                      class="form-control"
                      id=""
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.Account_Verification_Code") }}</label>
                  <div class="p_relative">
                    <input
                      type="password"
                      class="form-control"
                      id=""
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="col-12 mt-5 text-end">
                <input
                  type="submit"
                  class="
                    btn
                    bg_primary
                    focus_primary
                    hover_light
                    text-light
                    px-4
                  "
                  :value="$t('submitBtn')"
                />
              </div>
            </div>
          </form>
        </div>
        <div
          class="tab-pane fade"
          id="pills-contact"
          role="tabpanel"
          aria-labelledby="pills-contact-tab"
        >
          <!-- Change Password -->
          <form action="">
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.Current_Password") }}</label>
                  <div class="p_relative">
                    <input
                      type="password"
                      class="form-control"
                      id=""
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.New_Password") }}</label>
                  <div class="p_relative">
                    <input
                      type="password"
                      class="form-control"
                      id=""
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mt-4">
                <div class="input_wrapper">
                  <label class="mb-2">{{ $t("resPro.Confirm_Password") }}</label>
                  <div class="p_relative">
                    <input
                      type="password"
                      class="form-control"
                      id=""
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="col-12 mt-5 text-end">
                <input
                  type="submit"
                  class="
                    btn
                    bg_primary
                    focus_primary
                    hover_light
                    text-light
                    px-4
                  "
                  :value="$t('submitBtn')"
                />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>
  
<script>
import { API } from "../../../axois.js";
export default {
  name: "Profile",
  title: "Profile | Dashboard",
  data() {
    return {
      user: null,
    };
  },
  created() {
    this.user = this.$store.state.admin;
  },
  mounted() {},
  methods: {},
};
</script>
  
  