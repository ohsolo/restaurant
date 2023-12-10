<template>
  <section class="settings_screens">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">
            {{ $t("notiPg.main_title") }}
          </h4>
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-12">
          <form action="" class="az_globalForm" ref="myForm" @submit.prevent="handleForm" lazy-validation>
            <p class="fw-bold">{{ $t("notiPg.hd1") }}</p>
            <div class="rdBtns mt-4 mb-3">
              <div class="input_wrapper d-flex align-items-center">
                <input type="radio" class="me-2 form-check-input" name="secCheck" :checked="showSec.all ? true: false"
                  id="rdbtn1" value="all" @change="handleRadioBtn($event.target.value)" />
                <label for="rdbtn1">{{ $t("notiPg.rd1") }}</label>
              </div>
              <div class="input_wrapper mt-3 d-flex align-items-center">
                <input type="radio" class="me-2 form-check-input" name="secCheck" id="rdbtn2" value="city"
                  @change="handleRadioBtn($event.target.value)" />
                <label for="rdbtn2">{{ $t("notiPg.rd2") }}</label>
              </div>
              <div class="input_wrapper mt-3 d-flex align-items-center">
                <input type="radio" class="me-2 form-check-input" name="secCheck" id="rdbtn3" value="region"
                  @change="handleRadioBtn($event.target.value)" />
                <label for="rdbtn3">{{ $t("notiPg.rd3") }}</label>
              </div>
            </div>
            <div v-if="showSec.city">
              <div class="input_wrapper mb-2">
                <SearchContent url="admin/get-regions-by-name?search=" givenValue="Select Region" objKey="regions"
                  myKey="title" @my-call-back="regionCallBack" />
              </div>
            </div>
            <div v-if="showSec.region">
              <div class="input_wrapper mb-2">
                <SearchContent url="admin/get-riders-by-name-admin?search=" givenValue="Select Deliverer"
                  objKey="riders" myKey="name" @my-call-back="myCallBack" />
              </div>
            </div>
            <div class="input_wrapper">
              <input type="text" placeholder="Qualification" name="" required class="form-control"
                v-model="form.heading" />
            </div>
            <div class="input_wrapper mt-2">
              <textarea name="" class="form-control" placeholder="Message..." id="" cols="30" rows="3" required
                v-model="form.msg"></textarea>
            </div>
            <div class="btn_wrapper mt-5">
              <button type="button" class="border-0 btn-secondary px-2 py-1 rounded me-2">
                {{ $t("cancelBtn") }}
              </button>
              <button type="submit" class="
                  border-0
                  bg_primary
                  focus_primary
                  text-light
                  hover_light
                  px-2
                  py-1
                  rounded
                  me-2
                ">
                {{ $t("sendBtn") }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { API } from "../../../axois";
import SearchContent from "../../../components/admin-components/search-content/index.vue";
export default {
  name: "NotiSystem",
  title: "Notification System | Dashboard",
  components: { SearchContent },
  data() {
    return {
      showSec: {
        all: true,
        city: false,
        region: false,
      },
      form: {
        region_id: "",
        rider_id: "",
        heading: "",
        msg: "",
      },
    };
  },
  methods: {
    handleRadioBtn(value) {
      if (value == "all") {
        this.showSec = {
          all: true,
          city: false,
          region: false,
        };
        return;
      }
      if (value == "city") {
        this.showSec = {
          all: false,
          city: true,
          region: false,
        };
        return;
      }
      if (value == "region") {
        this.showSec = {
          all: false,
          city: false,
          region: true,
        };
        return;
      }
    },
    regionCallBack(item) {
      this.form.region_id = item.region_id;
      if (this.form.region_id == "" || item == "") {
        this.form.region_id = "";
      }
    },
    myCallBack(item) {
      this.form.rider_id = item.rider_id;
      if (this.form.rider_id == "" || item == "") {
        this.form.rider_id = "";
      }
    },
    handleForm() {
      this.$store.commit("loaderShow");
      let fd = new FormData();
      if (this.showSec.all) {
        fd.append("type", "all_riders");
      }
      if (this.showSec.city) {
        if (!this.form.region_id) {
          this.$store.commit("loaderHide");
          let msg = "No Region Selected";
          this.$store.dispatch("WarningToast", {
            message: msg,
          });
          return;
        } else {
          fd.append("type", "single_region");
        }
      }
      if (this.showSec.region) {
        if (!this.form.rider_id) {
          this.$store.commit("loaderHide");
          let msg = "No Rider Selected";
          this.$store.dispatch("WarningToast", {
            message: msg,
          });
          return;
        } else {
          fd.append("type", "single_rider");
          fd.append("rider_id", this.form.rider_id);
        }
      }
      fd.append("heading", this.form.heading);
      fd.append("text", this.form.msg);
      API(this, "admin/send-notification", "post", fd)
        .then((response) => {
          this.form = {
            region_id: "",
            rider_id: "",
            heading: "",
            msg: "",
          };
          this.$refs.myForm.reset();
          this.$store.commit("loaderHide");
          this.showSec = {
            all: true,
            city: false,
            region: false
          };
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((err) => {
          console.error("🚀 ~ file: notification-sys.vue ~ handleForm ~ err", err)
          this.$store.commit("loaderHide");
        });
    },
  },
};
</script>

<style>

</style>
