<template>
  <section class="reports_page">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold">{{ $t("asideRpt.hd1") }}</h4>
        </div>
      </div>
      <form action="" autocomplete="off" class="az_globalForm">
        <div class="row mt-5">
          <div class="col-12">
            <div class="d-flex">
              <div>
                <div class="input_wrapper">
                  <label for="order">
                    <input type="radio" class="form-check-input" name="search" id="order" value="search_by_order"
                      checked @click="handleRdBtn($event.target.value)" />
                    {{ $t("asideRpt.rd1") }}
                  </label>
                </div>
              </div>
              <div class="ms-4">
                <div class="input_wrapper">
                  <label for="period">
                    <input type="radio" class="form-check-input" name="search" value="search_by_period" id="period"
                      @click="handleRdBtn($event.target.value)" />
                    {{ $t("asideRpt.rd2") }}
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 mt-3">
            <div class="input_wrapper mt-2" v-if="showType == 'search_by_order'">
              <div class="loadIcon">
                <input type="text" class="form-control" placeholder="Search by order number" value="" />
                <fa icon="search" />
              </div>
            </div>
            <div class="input_wrapper mt-2 d-flex" v-if="showType == 'search_by_period'">
              <label for="" class="me-3 w-50 d-flex align-items-center">
                <span class="me-2">{{ $t("asideRpt.calenTxt1") }}</span>
                <input type="date" class="form-control" />
              </label>
              <label for="" class="d-flex w-50 align-items-center">
                <span class="me-2">{{ $t("asideRpt.calenTxt2") }}</span>
                <input type="date" class="form-control" />
              </label>
            </div>
          </div>
          <div class="col-lg-2 mt-3 align-self-end">
            <button class="
                border-0
                rounded
                px-2
                w-100
                py-2
                text-light
                bg_primary
                focus_primary
              ">
              {{ $t("filterBtn") }}
            </button>
          </div>
          <div class="col-lg-2 mt-3 align-self-end">
            <button class="
                border-0
                rounded
                px-2
                w-100
                py-2
                text-light
                bg_primary
                focus_primary
              ">
              {{ $t("clearBtn") }}
            </button>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <div class="d-flex flex-wrap">
              <div class="input_wrapper mx-2" style="min-width: 150px; width: 100%; max-width: 200px">
                <label for="" class="mb-2">{{ $t("asideRpt.label1") }}</label>
                <v-select :options="options"></v-select>
              </div>
              <div class="input_wrapper mx-2" style="min-width: 150px; width: 100%; max-width: 200px">
                <label for="" class="mb-2">{{ $t("asideRpt.label2") }}</label>
                <SearchContent url="admin/get-restaurants-by-name?search=" objKey="restaurants" myKey="title"
                  @my-call-back="myCallBack" />
              </div>
              <div class="input_wrapper mx-2" style="min-width: 150px; width: 100%; max-width: 200px">
                <label for="" class="mb-2">{{ $t("asideRpt.label3") }}</label>
                <SearchContent url="admin/get-riders-by-name?search=" objKey="riders" myKey="name"
                  @my-call-back="myCallBack" />
              </div>
              <div class="input_wrapper mx-2" style="min-width: 150px; width: 100%; max-width: 200px">
                <!-- <label for="" class="mb-2">{{ $t("asideRpt.label4") }}</label>
                <v-select :options="options"></v-select> -->
                <label for="" class="fs_small mb-1">
                  {{ $t("asideRpt.label4") }}
                </label>
                <select class="form-select" v-model="selectedVehicle">
                  <option selected>All</option>
                  <option v-for="item in vehicle" :key="item" :value="item.value">
                    {{ item.text }}
                  </option>
                </select>
              </div>
              <div class="input_wrapper mx-2" style="min-width: 150px; width: 100%; max-width: 200px">
                <label for="" class="mb-2">{{ $t("asideRpt.label5") }}</label>
                <SearchContent url="admin/get-regions-by-name?search=" objKey="regions" myKey="title"
                  @my-call-back="myCallBack" />
              </div>
              <div class="input_wrapper mx-2" style="min-width: 150px; width: 100%; max-width: 200px">
                <label for="" class="mb-2">{{ $t("asideRpt.label6") }}</label>
                <v-select :options="options"></v-select>
              </div>
              <div class="input_wrapper mx-2" style="min-width: 150px; width: 100%; max-width: 200px">
                <label for="" class="mb-2">{{ $t("asideRpt.label7") }}</label>
                <v-select :options="options"></v-select>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-12">
          <div class="
              flex_wrapper
              d-flex
              justify-content-center
              align-items-stretch
            ">
            <CustomCard :num="this.cardNum1" title="asideRpt.cardSm1" />
            <CustomCard :num="this.cardNum2" title="asideRpt.cardSm2" />
            <CustomCard :num="this.cardNum3" title="asideRpt.cardSm3" />
            <CustomCard :num="this.cardNum4" title="asideRpt.cardSm4" />
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-hover" style="min-width: 1200px">
              <thead>
                <tr>
                  <th v-for="item in thead" :key="item" class="pt-3 bg-dark text-light">
                    <h5 class="fs_small text-center">{{ $t(item) }}</h5>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="15" class="text-center">
                    <span class="text-secondary">{{ $t("noData") }}</span>
                  </td>
                </tr>
                <tr>
                  <td align="center" valign="middle">
                    <p class="m_0">1023215</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">League</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">12/16/12</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">12/16/12</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">12/16/12</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">12/16/12</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Neno</p>
                  </td>
                  <td align="center" valign="middle">
                    <fa class="t_primary" v-if="'car' == 'car'" icon="car" />
                    <fa class="t_primary" v-if="'car' == 'bike'" icon="motorcycle" />
                    <fa class="t_primary" v-if="'car' == 'bicycle'" icon="bicycle" />
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Karachi</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Rs$7.00</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Money</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">External</p>
                  </td>
                  <td align="center" valign="middle">
                    <button type="button" class="border-0 rounded btn-warning text-light px-2 py-1">
                      <fa icon="eye" />
                    </button>
                  </td>
                  <td align="center" valign="middle">
                    <button type="button" class="
                        border-0
                        rounded
                        btn-secondary
                        text-light
                        px-2
                        py-1
                      ">
                      Deliver
                    </button>
                  </td>
                  <td align="center" valign="middle">
                    <button type="button" class="border-0 rounded px-2 py-1">
                      <fa icon="check" class="text-success" />
                    </button>
                  </td>
                </tr>
                <tr>
                  <td align="center" valign="middle">
                    <p class="m_0">1023215</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">League</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">12/16/12</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">12/16/12</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">12/16/12</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">12/16/12</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Neno</p>
                  </td>
                  <td align="center" valign="middle">
                    <fa class="t_primary" v-if="'bike' == 'car'" icon="car" />
                    <fa class="t_primary" v-if="'bike' == 'bike'" icon="motorcycle" />
                    <fa class="t_primary" v-if="'bike' == 'bicycle'" icon="bicycle" />
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Karachi</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Rs$7.00</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">Money</p>
                  </td>
                  <td align="center" valign="middle">
                    <p class="m_0">External</p>
                  </td>
                  <td align="center" valign="middle">
                    <button type="button" class="border-0 rounded btn-warning text-light px-2 py-1">
                      <fa icon="eye" />
                    </button>
                  </td>
                  <td align="center" valign="middle">
                    <button type="button" class="
                        border-0
                        rounded
                        btn-secondary
                        text-light
                        px-2
                        py-1
                      ">
                      Deliver
                    </button>
                  </td>
                  <td align="center" valign="middle">
                    <button type="button" class="border-0 rounded px-2 py-1">
                      <fa icon="ban" class="text-danger" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { API } from "../../../axois.js";
import SearchContent from "../../../components/admin-components/search-content/index.vue";
import CustomCard from "./card.vue";
export default {
  name: "Reports",
  title: "Reports | Dashboard",
  components: { SearchContent, CustomCard },
  data() {
    return {
      thead: [
        "asideRpt.th1",
        "asideRpt.th2",
        "asideRpt.th3",
        "asideRpt.th4",
        "asideRpt.th5",
        "asideRpt.th6",
        "asideRpt.th7",
        "asideRpt.th8",
        "asideRpt.th9",
        "asideRpt.th10",
        "asideRpt.th11",
        "asideRpt.th12",
        "asideRpt.th13",
        "asideRpt.th14",
        "Action",
      ],
      showType: "search_by_order",
      options: [],
      filter: "",
      vehicle: [
        {
          value: "bike",
          text: "Bike",
        },
        {
          value: "car",
          text: "Car",
        },
        {
          value: "bicycle",
          text: "Bicycle",
        },
      ],
      selectedVehicle: "All",
      cardNum1: 0,
      cardNum2: 0,
      cardNum3: 0,
      cardNum4: 0,
      // filteredStore: "",
    };
  },
  created() {
    this.getRecords();
    for (let i = 1; i < 101; i++) {
      this.options.push(i);
    }
  },
  mounted() { },
  methods: {
    getRecords() {
      // API(this, "admin/report-screen-data", "get", null)
      //   .then((response) => {
      //     this.filter = response.data.response.detail;
      //   })   
      //   .catch((err) => {
      //     console.log(err);
      //   });
    },
    handleRdBtn(value) {
      this.showType = value;
    },
    myCallBack(item) {
    },
    // filterStore(event) {
    //   let value = event.target.value;
    //   let find=value.toLowerCase();
    //   if (value === '') {
    //     this.filteredStore = '';
    //     return
    //   }
    //   if (event.target.name == "filter_store") {
    //     try {
    //       this.filteredStore = this.filter.all_restaurants.filter((x) => {
    //         let title = x.title.toLowerCase();
    //         return title.includes(find);
    //       }
    //       );
    //     } catch (err) {
    //       console.log(err);
    //     }
    //   }
    // },
  },
};
</script>

