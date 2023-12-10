<template>
  <section class="settings_screens">
    <div class="container-fluid">
      <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">
        {{ $t("gen_set.main_title") }}
      </h4>
      <form action="" class="az_globalForm" @submit.prevent="handleForm">
        <div class="row">
          <div class="col-12">
            <p class="m_0 fw-bold mb-3">
              {{ $t("gen_set.hd1") }}
            </p>
            <div class="input_wrapper">
              <input type="radio" class="form-check-input me-2" name="noti" id="rdBtn1" :checked="
                records.sent_to_all_delivers_who_are_within_radius == 1
              " :value="records.sent_to_all_delivers_who_are_within_radius" @click="
                  handleBtnCheck('sent_to_all_delivers_who_are_within_radius')
                " />
              <label for="rdBtn1">{{ $t("gen_set.rd1") }}</label>
            </div>
            <div class="input_wrapper mt-2">
              <input type="radio" class="form-check-input me-2" name="noti" id="rdBtn2" :checked="
                records.send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius ==
                1
              " :value="
                  records.send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius
                " @click="
                  handleBtnCheck(
                    'send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius'
                  )
                " />
              <label for="rdBtn2">{{ $t("gen_set.rd2") }}</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p class="fw-bold m_0 mt-4">
              {{ $t("gen_set.hd2") }}
            </p>
            <div class="input_wrapper mt-4">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.bike") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_distance_for_reception_of_alert_for_bike_per_km" :value="
                    records.maximum_distance_for_reception_of_alert_for_bike_per_km
                  " @change="handleInput($event)" />
                KM
              </label>
            </div>
            <div class="input_wrapper mt-2">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.cycle") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_distance_for_reception_of_alert_for_bicycle_per_km" :value="
                    records.maximum_distance_for_reception_of_alert_for_bicycle_per_km
                  " @change="handleInput($event)" />
                KM
              </label>
            </div>
            <div class="input_wrapper mt-2">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.car") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_distance_for_reception_of_alert_for_car_per_km" :value="
                    records.maximum_distance_for_reception_of_alert_for_car_per_km
                  " @change="handleInput($event)" />
                KM
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p class="fw-bold m_0 mt-4">
              {{ $t("gen_set.hd3") }}
            </p>
            <div class="input_wrapper mt-4">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.bike") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_distance_to_travel_per_delivery_for_bike" :value="
                    records.maximum_distance_to_travel_per_delivery_for_bike
                  " @change="handleInput($event)" />
                KM
              </label>
            </div>
            <div class="input_wrapper mt-2">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.cycle") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_distance_to_travel_per_delivery_for_bicycle" :value="
                    records.maximum_distance_to_travel_per_delivery_for_bicycle
                  " @change="handleInput($event)" />
                KM
              </label>
            </div>
            <div class="input_wrapper mt-2">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.car") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_distance_to_travel_per_delivery_for_car" :value="
                    records.maximum_distance_to_travel_per_delivery_for_car
                  " @change="handleInput($event)" />
                KM
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p class="fw-bold m_0 mt-4">{{ $t("gen_set.hd4") }}</p>
            <div class="input_wrapper mt-4">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.bike") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_orders_per_delivery_person_for_bike"
                  :value="records.maximum_orders_per_delivery_person_for_bike" @change="handleInput($event)" />
                KM
              </label>
            </div>
            <div class="input_wrapper mt-2">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.cycle") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_orders_per_delivery_person_for_bicycle" :value="
                    records.maximum_orders_per_delivery_person_for_bicycle
                  " @change="handleInput($event)" />
                KM
              </label>
            </div>
            <div class="input_wrapper mt-2">
              <label for="" class="d-flex align-items-center">
                <span style="width: 100px">{{ $t("gen_set.car") }}</span>
                <input type="text" class="form-control ms-4 me-1 text-center" style="width: 80px"
                  name="maximum_orders_per_delivery_person_for_car"
                  :value="records.maximum_orders_per_delivery_person_for_car" @change="handleInput($event)" />
                KM
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p class="m_0 fw-bold mt-4">{{ $t("gen_set.hd5") }}</p>
            <div class="input_wrapper mt-4">
              <input type="checkbox" class="form-check-input me-2" id="checkBtn44" :checked="
                records.only_bring_broken_orders_to_the_same_address != 0
              " name="only_bring_broken_orders_to_the_same_address"
                :value="records.only_bring_broken_orders_to_the_same_address" @click="
                  handleBtnCheck('only_bring_broken_orders_to_the_same_address')
                " />
              <label for="checkBtn44">{{ $t("gen_set.check1") }}</label>
            </div>
            <div class="input_wrapper mt-2">
              <input type="checkbox" class="form-check-input me-2" id="checkBtn45"
                name="allow_to_bring_orders_from_different_addresses" :checked="
                  records.allow_to_bring_orders_from_different_addresses != 0
                " :value="records.allow_to_bring_orders_from_different_addresses" @click="
                  handleBtnCheck(
                    'allow_to_bring_orders_from_different_addresses'
                  )
                " />
              <label for="checkBtn45">{{ $t("gen_set.check2") }}</label>
            </div>
          </div>
        </div>
        <div class="btn_wrapper mt-5 mb-4">
          <button type="button" class="border-0 btn-secondary px-2 py-1 rounded me-2">
            {{ $t("cancelBtn") }}
          </button>
          <button type="submit" class="border-0 bg_primary focus_primary text-light hover_light px-2 py-1 rounded me-2">
            {{ $t("sendBtn") }}
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import { API } from "../../../axois";
export default {
  name: "GenSettings",
  title: "General Settings | Dashboard",
  data() {
    return {
      records: [],
    };
  },
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      API(this, "admin/settings", "get", null)
        .then((response) => {
          this.records = response.data.response.detail;
        })
        .catch((err) => {
          console.error("🚀 ~ file: general-settings.vue ~ getRecords ~ err", err)
          alert("Data not found");
        });
    },
    handleInput(event) {
      this.records[event.target.name] = event.target.value;
    },
    handleBtnCheck(key) {
      // For radio
      if (
        key == "sent_to_all_delivers_who_are_within_radius" ||
        key ==
        "send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius"
      ) {
        if (key == "sent_to_all_delivers_who_are_within_radius") {
          this.records.sent_to_all_delivers_who_are_within_radius = 1;
          this.records.send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius = 0;
        } else {
          this.records.send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius = 1;
          this.records.sent_to_all_delivers_who_are_within_radius = 0;
        }
        return;
      }
      //   for checkbox
      if (
        key == "only_bring_broken_orders_to_the_same_address" ||
        key == "allow_to_bring_orders_from_different_addresses"
      ) {
        if (key == "only_bring_broken_orders_to_the_same_address") {
          if (this.records.only_bring_broken_orders_to_the_same_address == 1) {
            this.records.only_bring_broken_orders_to_the_same_address = 0;
          } else {
            this.records.only_bring_broken_orders_to_the_same_address = 1;
          }
        }

        if (key == "allow_to_bring_orders_from_different_addresses") {
          if (
            this.records.allow_to_bring_orders_from_different_addresses == 1
          ) {
            this.records.allow_to_bring_orders_from_different_addresses = 0;
          } else {
            this.records.allow_to_bring_orders_from_different_addresses = 1;
          }
        }
        return;
      }
    },
    handleForm() {
      this.$store.commit("loaderShow");
      API(this, "admin/update-settings", "post", this.records)
        .then((response) => {
          this.$store.commit("loaderHide");
          this.$store.dispatch("SuccessToast", {
            message: response.data.response.message,
          });
        })
        .catch((err) => {
          this.$store.commit("loaderHide");
          const obj = err.response.data.detail;
          let msg = []
          Object.keys(obj).forEach(function (key) {
            msg.push(obj[key][0])
          });
          this.$store.dispatch("FailToast", {
            message: msg,
          })
        });
    },
  },
};
</script>

<style>

</style>
