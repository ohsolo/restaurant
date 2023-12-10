<template>
  <section class="settings_screens">
    <div class="container-fluid">
      <form action="" class="az_globalForm" @submit.prevent="handleForm">
        <div class="row">
          <div class="col-12">
            <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">
              {{ $t("val_dis.main_title") }}
            </h4>
          </div>
        </div>
        <div class="row mb-5">
          <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
            <p class="mb-4 fw-bold">{{ $t("val_dis.hd1") }}</p>
            <table class="table table-hover" style="max-width: 500px">
              <thead>
                <tr>
                  <th class="bg-dark text-light">
                    <h5 class="text-center m_0">{{ $t("val_dis.th1") }}</h5>
                  </th>
                  <th class="bg-dark text-light">
                    <h5 class="text-center m_0">{{ $t("val_dis.th2") }}</h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center" width="50%">0.5KM</td>
                  <td class="text-center" width="50%">
                    <input type="text" name="values_by_distance_traveled_0_5_km"
                      :value="records.values_by_distance_traveled_0_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">1.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_1_0_km"
                      :value="records.values_by_distance_traveled_1_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">1.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_1_5_km"
                      :value="records.values_by_distance_traveled_1_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">2.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_2_0_km"
                      :value="records.values_by_distance_traveled_2_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">2.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_2_5_km"
                      :value="records.values_by_distance_traveled_2_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">3.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_3_0_km"
                      :value="records.values_by_distance_traveled_3_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">3.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_3_5_km"
                      :value="records.values_by_distance_traveled_3_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">4.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_4_0_km"
                      :value="records.values_by_distance_traveled_4_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">4.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_4_5_km"
                      :value="records.values_by_distance_traveled_4_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">5.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_5_0_km"
                      :value="records.values_by_distance_traveled_5_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">5.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_5_5_km"
                      :value="records.values_by_distance_traveled_5_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">6.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_6_0_km"
                      :value="records.values_by_distance_traveled_6_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">6.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_6_5_km"
                      :value="records.values_by_distance_traveled_6_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">7.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_7_0_km"
                      :value="records.values_by_distance_traveled_7_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">7.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_7_5_km"
                      :value="records.values_by_distance_traveled_7_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">8.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_8_0_km"
                      :value="records.values_by_distance_traveled_8_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">8.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_8_5_km"
                      :value="records.values_by_distance_traveled_8_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">9.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_9_0_km"
                      :value="records.values_by_distance_traveled_9_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">9.5KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_9_5_km"
                      :value="records.values_by_distance_traveled_9_5_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
                <tr>
                  <td class="text-center">10.0KM</td>
                  <td class="text-center">
                    <input type="text" name="values_by_distance_traveled_10_0_km"
                      :value="records.values_by_distance_traveled_10_0_km" class="border-0 form-control text-center"
                      @change="handleInput($event)" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
            <p class="mb-4 fw-bold">{{ $t("val_dis.hd2") }}</p>
            <div class="d-flex align-items-center">
              <div class="border m_0 px-3 py-1 d-flex align-items-center" style="width: 150px">
                <small>+</small>R$
                <div class="input_wrapper">
                  <input type="text" class="form-control border-0 ms-2" name="values_over_10_0_km_charge"
                    :value="records.values_over_10_0_km_charge" @change="handleInput($event)" />
                </div>
              </div>
              <span class="ms-2">{{ $t("val_dis.pkmEx") }}</span>
            </div>
            <p class="mb-4 mt-4 fw-bold">Rider Return Fee</p>
            <div class="d-flex align-items-center">
              <div class="border m_0 px-3 py-1 d-flex align-items-center" style="width: 150px">
                <small>+</small>R$
                <div class="input_wrapper">
                  <input type="text" class="form-control border-0 ms-2" name="rider_return_fee"
                    :value="records.rider_return_fee" @change="handleInput($event)" />
                </div>
              </div>
              <span class="ms-2">{{ $t("val_dis.pkmEx") }}</span>
            </div>
            <p class="mb-4 mt-4 fw-bold">
              Platform fee percentage for deliverer per ride
            </p>
            <div class="d-flex align-items-center">
              <div class="border m_0 px-3 py-1 d-flex align-items-center" style="width: 150px">
                <small>+</small>R$
                <div class="input_wrapper">
                  <input type="text" class="form-control border-0 ms-2"
                    name="platform_fee_percentage_for_deliverer_per_ride" :value="
                      records.platform_fee_percentage_for_deliverer_per_ride
                    " @change="handleInput($event)" />
                </div>
              </div>
              <span class="ms-2">{{ $t("val_dis.pkmEx") }}</span>
            </div>
            <p class="mb-4 fw-bold mt-5">
              {{ $t("val_dis.hd3") }}
            </p>
            <div class="input_wrapper">
              <label for="rd_btn1">
                <input type="radio" id="rd_btn1" name="charge_return_tax" class="form-check-input"
                  :checked="records.charge_return_tax == 0" value="0" @change="handleInput($event)" />
                <span class="ms-2">{{ $t("none") }}</span>
              </label>
              <br />
              <label for="rd_btn2" class="mt-2">
                <input type="radio" id="rd_btn2" name="charge_return_tax" class="form-check-input"
                  :checked="records.charge_return_tax == 1" value="1" @change="handleInput($event)" />
                <span class="ms-2">{{ $t("yes") }}</span>
              </label>
            </div>
            <p class="mb-4 fw-bold mt-5" v-if="records.charge_return_tax == 1">
              {{ $t("val_dis.hd4") }}
            </p>
            <div class="d-flex align-items-center" v-if="records.charge_return_tax == 1">
              <div class="border m_0 px-3 py-1 d-flex align-items-center" style="width: 150px">
                <small>+</small>R$
                <div class="input_wrapper">
                  <input type="text" class="form-control border-0 ms-2" name="return_tax_to_establishment"
                    :value="records.return_tax_to_establishment" @change="handleInput($event)" />
                </div>
              </div>
              <span class="ms-2">{{ $t("val_dis.prR") }}</span>
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
          </div>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import { API } from "../../../axois";
export default {
  name: "ValuesDistance",
  title: "Values By Distance | Dashboard",
  data() {
    return {
      showTaxarea: false,
      records: [],
    };
  },
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      API(this, "admin/settings", "get")
        .then((response) => {
          this.records = response.data.response.detail;
        })
        .catch((err) => {
          console.error("🚀 ~ file: value-distance.vue ~ getRecords ~ err", err)
          alert("Data not found");
        });
    },
    handleInput(event) {
      this.records[event.target.name] = event.target.value;
    },
    handleForm() {
      this.$store.commit("loaderShow");
      API(this, "admin/update-settings-page-two", "post", this.records)
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

<style lang="scss" scoped>
.focus_none:focus {
  border: 0;
  outline: 0;
  box-shadow: none;
}
</style>
