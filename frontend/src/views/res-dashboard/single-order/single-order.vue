<template>
  <div class="container-fluid pb-5">
    <div class="row">
      <div class="col-12">
        <router-link class="border-0 rounded px-4 py-2 text-light bg_primary focus_primary" to="/resturant-dashboard">
          <fa icon="arrow-left" />
        </router-link>
        <button class="
            border-0
            rounded
            px-4
            py-2
            text-light
            bg_primary
            focus_primary
            mb-3
            mt-3
            ms-auto
            d-block
          " v-if="record?.status == 'pending'" @click="() => updateRiderLoc()">
          {{ isLoading ? $t('singleOrder.loading') : $t('singleOrder.Referesh') }}
        </button>
      </div>
      <div class="col-12 mb-4" v-if="record?.status == 'research'">
        <div class="d-flex align-items-center justify-content-center">
          <h5 class="mb-0">{{$t('singleOrder.Searching_for_Rider')}}</h5>
          &nbsp; &nbsp;
          <template v-for="x in 3" :key="x">
            <div class="spinner-grow spinner-grow-sm" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            &nbsp;
          </template>
        </div>
      </div>
    </div>
    <div class="row mt-5" v-if="showMap">
      <div class="col-12" v-if="MAP_KEY !== null">
        <GoogleMap :api-key="MAP_KEY" style="width: 100%; height: 500px" :center="center" :zoom="12" ref="myMap">
          <!-- <Marker :options="riderMarker" /> -->
          <CustomMarker :options="{ position: center, anchorPoint: 'BOTTOM_CENTER' }"
            v-if="record?.order_accepted_by_rider">
            <div style="text-align: center">
              <img src="https://litoral.iinv.tech/logo.png" width="25" height="25" class="rounded-circle" />
            </div>
          </CustomMarker>
        </GoogleMap>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="d-flex align-items-center justify-content-end">
          <button v-if="record?.status == 'delivered' && !record?.rider_rated" class="
              border-0
              rounded
              px-4
              py-2
              text-light
              bg_primary
              focus_primary
              mb-3
              mt-3
              ms-auto
              d-block
            " data-bs-toggle="modal" data-bs-target="#exampleModal1" @click="getRatingQuestions">
            {{$t('singleOrder.Give_Feedback')}}
          </button>
          <button @click="initiateChat" class="
              border-0
              rounded
              px-4
              py-2
              text-light
              bg_primary
              focus_primary
              my-3
              me-3
            " v-if="
              !record?.chat_rider_started_from_rest &&
              record?.status == 'pending'
            ">
            {{$t('singleOrder.Start_Chat')}}
          </button>
          <button class="
              border-0
              rounded
              px-4
              py-2
              text-light
              bg_primary
              focus_primary
              my-3
              me-3
            " data-bs-toggle="modal" data-bs-target="#exampleModal4" @click="getQuestions"
            v-if="record?.status == 'research' || record?.status == 'pending'">
            {{$t('singleOrder.Cancel_Order')}}
          </button>
          <button class="
              border-0
              rounded
              px-4
              py-2
              text-light
              bg_primary
              focus_primary
              my-3
            " v-if="record?.status == 'pending'" data-bs-toggle="modal" data-bs-target="#exampleModal3">
            {{$t('singleOrder.Add_Occurence')}}
          </button>
        </div>
      </div>
    </div>
    <div class="row mb-0 mt-5" v-if="record?.status == 'rejected'">
      <div class="col-12">
        <h5 class="mb-2 t_primary">{{$t('singleOrder.Order_has_been_cancelled')}}</h5>
        <p class="mb-1">
          <b>{{$t('singleOrder.Reason')}}</b> : {{ record?.order_cancel_question ?? "-" }}
        </p>
        <p class="mb-0">
          <b>{{$t('singleOrder.Comment')}}</b> : {{ record?.order_cancel_comment ?? "-" }}
        </p>
      </div>
    </div>
    <div class="row mb-5 mt-3">
      <div class="col-md-6 col-sm-12 mt-4">
        <div class="card">
          <div class="card-header">
            <h5 class="text-center mt-2">{{$t('singleOrder.Address_Details')}}</h5>
          </div>
          <div class="card-body">
            <p>
              <b>{{$t('singleOrder.Location')}} :</b>
              {{ record?.address_detail?.location ?? "&nbsp;-" }}
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 mt-4">
        <div class="card">
          <div class="card-header">
            <h5 class="text-center mt-2">{{$t('singleOrder.Branch_Details')}}</h5>
          </div>
          <div class="card-body">
            <p><b>{{$t('singleOrder.Location')}} :</b> {{ record?.branch?.location ?? "&nbsp;-" }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 mt-4">
        <div class="card">
          <div class="card-header">
            <h5 class="text-center mt-2">{{$t('singleOrder.Restaurant_Details')}}</h5>
          </div>
          <div class="card-body">
            <div class="text-center mb-4">
              <img :src="record?.restaurant?.logo_url" width="95" class="img-fluid" />
            </div>
            <p><b>{{$t('singleOrder.Name')}} :</b> {{ record?.restaurant?.title ?? "&nbsp;-" }}</p>
            <p><b>{{$t('singleOrder.Email')}} :</b> {{ record?.restaurant?.email ?? "&nbsp;-" }}</p>
            <p>
              <b>{{$t('singleOrder.Rating')}} :</b>
              {{ record?.restaurant?.total_rating ?? "&nbsp;-" }}
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 mt-4">
        <div class="card">
          <div class="card-header">
            <h5 class="text-center mt-2">{{$t('singleOrder.Rider_Details')}}</h5>
          </div>
          <div class="card-body">
            <div class="text-center mb-4">
              <img :src="record?.rider?.profile_image_url" width="95" class="img-fluid" />
            </div>
            <p><b>{{$t('singleOrder.Name')}} :</b> {{ record?.rider?.name ?? "&nbsp;-" }}</p>
            <p><b>{{$t('singleOrder.Phone')}} :</b> {{ record?.rider?.phone ?? "&nbsp;-" }}</p>
            <p><b>{{$t('singleOrder.Email')}} :</b> {{ record?.rider?.email ?? "&nbsp;-" }}</p>
            <p>
              <b>{{$t('singleOrder.Rating')}} :</b> {{ record?.rider?.total_rating ?? "&nbsp;-" }}
            </p>
            <p>
              <b>Cnh :</b>&nbsp;
              <a :href="record?.rider?.cnh_image_url" target="_blank" v-if="record?.rider?.cnh_image_url">
                <fa icon="eye" class="text-dark" title="View" />
              </a><span v-else>-</span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 mt-5">
        <div class="card">
          <div class="card-header">
            <h5 class="text-center mt-2">{{$t('singleOrder.Order_Details')}}</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table_3302s" style="min-width: 550px">
                <tbody>
                  <tr>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Order_Number')}} :</b> {{ record?.order_number || "-" }}
                      </p>
                    </td>
                    <td>
                      <p class="text-capitalize">
                        <b>{{$t('singleOrder.Status')}} :</b>
                        {{
                        record?.status == "pending"
                        ? "Inprocess"
                        : record?.status == "research"
                        ? "searching"
                        : record?.status == "rejected"
                        ? "cancelled"
                        : record?.status
                        }}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p class="text-capitalize">
                        <b>{{$t('singleOrder.Order_Method')}} :</b> {{ record?.order_method || "-" }}
                      </p>
                    </td>
                    <td>
                      <p class="text-capitalize">
                        <b>{{$t('singleOrder.Payment_Method')}} :</b>
                        {{ record?.payment_method || "-" }}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p class="text-capitalize">
                        <b>{{$t('singleOrder.Pickup_Time')}} :</b>
                        {{ record?.pickup_time || "- : -" }}
                      </p>
                    </td>
                    <td>
                      <p class="text-capitalize">
                        <b>{{$t('singleOrder.Output_Time')}} :</b> {{ record?.output_time || "-" }}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Delivery_Charges')}} :</b>
                        {{ record?.delivery_charges || "-" }}
                      </p>
                    </td>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Gross_Profit')}} :</b> {{ record?.gross_profit || "-" }}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p><b>{{$t('singleOrder.Net_Profit')}} :</b> {{ record?.net_profit || "-" }}</p>
                    </td>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Order_Amount')}} :</b>
                        {{ record?.rest_order_amount || "-" }}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Rider_Charges')}} :</b>
                        {{ record?.platform_charges_to_rider || "-" }}
                      </p>
                    </td>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Restaurant_Charges')}} :</b>
                        {{ record?.platform_charges_to_restaurant || "-" }}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Rider_Retu_Fee')}} :</b>
                        {{ record?.rider_return_fee || "-" }}
                      </p>
                    </td>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Total_Distance')}} :</b>
                        {{ record?.total_distance || "-" }}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Dishes_Info')}} :</b> {{ record?.dishes_info || "-" }}
                      </p>
                    </td>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Obeservations')}} :</b> {{ record?.observations || "-" }}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Compliments')}} :</b> {{ record?.compliments || "-" }}
                      </p>
                    </td>
                    <td>
                      <p><b>{{$t('singleOrder.Response')}} :</b> {{ record?.response || "-" }}</p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p><b>{{$t('singleOrder.Remarks')}} :</b> {{ record?.remarks || "-" }}</p>
                    </td>
                    <td>
                      <p>
                        <b>{{$t('singleOrder.Delivery_Comments')}} :</b> {{ record?.comments || "-" }}
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-if="record?.status == 'pending'">
      <div class="col-12" id="ChatBox">
        <ChatBox sendMessageAPI="rest/add-chat-message/" getMessageAPI="rest/get-messages/" :ID="singleOrderID"
          :matchID="record?.rest_id" />
      </div>
    </div>
  </div>
  <!-- Report Occurrences -->
  <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModal3Label" aria-hidden="true"
    ref="close_myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn ms-auto d-block focus_primary fs-4" style="line-height: 0"
                data-bs-dismiss="modal" aria-label="Close">
                <fa icon="times" class="t_primary" />
              </button>
            </div>
          </div>
          <h5 class="text-center mb-4">
            {{$t('singleOrder.Give your reason?')}}<span class="text-danger">*</span>
          </h5>
          <form action="" class="" @submit.prevent="reportOcc">
            <div class="row mt-4">
              <div class="col-12">
                <div class="input_wrapper">
                  <textarea class="form-control" cols="30" rows="3" required v-model="reason"
                    placeholder="Descreva or reason"></textarea>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 text-center">
                <button type="button" data-bs-dismiss="modal" class="btn px-5 text-light btn-secondary"
                  ref="close_myModal">
                  {{$t('singleOrder.Close')}}
                </button>
                <input type="submit" class="ms-3 px-5 btn focus_primary text-light bg_primary" value="Send" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Cancel Orders -->
  <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModal4Label" aria-hidden="true"
    ref="close_myModal2">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn ms-auto d-block focus_primary fs-4" style="line-height: 0"
                data-bs-dismiss="modal" aria-label="Close">
                <fa icon="times" class="t_primary" />
              </button>
            </div>
          </div>
          <form action="" class="" @submit.prevent="cancelOrder">
            <div class="row mt-4">
              <div class="col-12 text-center" v-if="questionsLoading">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <div class="col-12" v-if="this.cancelQuestions.length">
                <p>{{$t('singleOrder.Select_option')}}<span class="text-danger">*</span></p>
                <div class="input_wrapper" v-for="x in cancelQuestions" :key="x.order_cancel_question_id">
                  <label :for="x.order_cancel_question_id">
                    <input type="radio" class="form-check-input mb-3" name="cancel_question"
                      :id="x.order_cancel_question_id" @click="handleQuestionRd(x)" />
                    {{ x.title }}
                  </label>
                </div>
              </div>
              <div class="col-12 mt-4">
                <p>{{$t('singleOrder.Comment')}}<span class="text-danger">*</span></p>
                <div class="input_wrapper">
                  <textarea class="form-control" cols="30" rows="3" required
                    v-model="cancelOrderForm.order_cancel_comment" placeholder="Descreva or reason"></textarea>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 text-center">
                <button type="button" data-bs-dismiss="modal" class="btn px-5 text-light btn-secondary"
                  ref="close_myModal">
                  {{$t('singleOrder.Close')}}
                </button>
                <input type="submit" class="ms-3 px-5 btn focus_primary text-light bg_primary" value="Send" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Feedback Rider -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true"
    ref="close_myModal3">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn ms-auto d-block focus_primary fs-4" style="line-height: 0"
                data-bs-dismiss="modal" aria-label="Close">
                <fa icon="times" class="t_primary" />
              </button>
            </div>
          </div>
          <form action="" class="" @submit.prevent="feedbackRider">
            <div class="row mt-4">
              <div class="col-12 text-center" v-if="questionsLoading">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <div class="col-12" v-if="this.ratingQuestions.length">
                <div class="d-flex mb-2 justify-content-between" v-for="x in ratingQuestions"
                  :key="x.rider_rating_question_id">
                  <p class="mb-0">{{ x.question }}</p>
                  <StarRating :id="x.id" :rating="x.rating" @get-rating="getRating" />
                </div>
              </div>
              <div class="col-12 mt-4">
                <p>{{$t('singleOrder.Comment')}}<span class="text-danger">*</span></p>
                <div class="input_wrapper">
                  <textarea class="form-control" cols="30" rows="3" required v-model="feedbackcomment"
                    placeholder="Descreva or reason"></textarea>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 text-center">
                <button type="button" data-bs-dismiss="modal" class="btn px-5 text-light btn-secondary"
                  ref="close_myModal">
                  {{$t('singleOrder.Close')}}
                </button>
                <input type="submit" class="ms-3 px-5 btn focus_primary text-light bg_primary" value="Send" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
      
<script>
import { API } from "../../../axois.js";
import { GoogleMap, Marker, CustomMarker } from "vue3-google-map";
import { ChatBox, StarRating } from "../../../components";
export default {
  name: "SingleOrder",
  title: "Order | Dashboard",
  components: { ChatBox, GoogleMap, Marker, CustomMarker, StarRating },
  data() {
    return {
      record: null,
      MAP_KEY: null,
      center: null,
      branchMarker: null,
      locationMarker: null,
      riderMarker: null,
      showMap: true,
      isLoading: false,
      reason: null,
      singleOrderID: null,
      cancelQuestions: [],
      questionsLoading: false,
      cancelOrderForm: {
        order_cancel_question_id: "",
        order_cancel_question: "",
        order_cancel_comment: "",
      },
      ratingQuestions: [],
      feedbackcomment: null,
    };
  },
  created() {
    this.singleOrderID = this.$route.params.id;
    this.MAP_KEY = import.meta.env.VITE_GOOGLE_MAPS_API;
    this.getRecord();
  },
  methods: {
    getRecord() {
      this.$store.commit("loaderShow");
      API(this, `admin/order-details/${this.singleOrderID}`, "post", null)
        .then((res) => {
          let data = res?.data?.response?.detail;
          this.record = data?.order;
          if (data?.order?.status == "pending") {
            this.showMap = true;
            this.center = {
              lat: data?.rider_location?.latitude,
              lng: data?.rider_location?.longitude,
            };
            this.riderMarker = {
              position: {
                lat: data?.rider_location?.latitude,
                lng: data?.rider_location?.longitude,
              },
              label: "R",
              title: "Rider",
            };
            this.branchMarker = {
              lat: data?.order?.branch?.latitude,
              lng: data?.order?.branch?.longitude,
            };
            this.locationMarker = {
              lat: data?.order?.address_detail?.latitude,
              lng: data?.order?.address_detail?.longitude,
            };
            this.getDirection();
          } else {
            this.showMap = false;
          }
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: view-single-order.vue ~ getRecord ~ err",
            err
          );
          this.$store.commit("loaderHide");
        });
    },
    getDirection() {
      var directionsService = new google.maps.DirectionsService();
      var directionsDisplay = new google.maps.DirectionsRenderer();
      directionsDisplay.setMap(this.$refs.myMap.map);

      this.calculateAndDisplayRoute(
        directionsService,
        directionsDisplay,
        this.branchMarker,
        this.locationMarker
      );
    },
    //google maps API's direction service
    calculateAndDisplayRoute(
      directionsService,
      directionsDisplay,
      start,
      destination
    ) {
      directionsService.route(
        {
          origin: start,
          destination: destination,
          travelMode: "DRIVING",
        },
        function (response, status) {
          if (status === "OK") {
            directionsDisplay.setDirections(response);
          } else {
            window.alert("Directions request failed due to " + status);
          }
        }
      );
    },
    updateRiderLoc() {
      if (!this.record?.order_accepted_by_rider) {
        this.isLoading = true;
        this.getRecord();
        this.isLoading = false;
      } else {
        this.isLoading = true;
        API(
          this,
          `admin/get-latest-location/${this.singleOrderID}`,
          "post",
          null
        )
          .then((res) => {
            let data = res.data.response.detail.rider_location;
            this.center = {
              lat: data?.latitude,
              lng: data?.longitude,
            };
            this.riderMarker = {
              position: {
                lat: data?.latitude,
                lng: data?.longitude,
              },
              label: "R",
              title: "Rider",
            };
            this.isLoading = false;
          })
          .catch((err) => {
            console.error("🚀 ~ file: view-single-order.vue ~ err", err);
            this.isLoading = false;
          });
      }
    },
    reportOcc() {
      this.$store.commit("loaderShow");
      this.$refs.close_myModal.click();
      API(
        this,
        `rest/store-restaurant-occurrence/${this.record?.order_id}`,
        "post",
        {
          reason: this.reason,
        }
      )
        .then((res) => {
          this.reason = null;
          this.$store.dispatch("SuccessToast", {
            message: res.data.response.message,
          });
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error("🚀 ~ file: show-orders.vue ~ getRecords ~ err", err);
          this.$store.commit("loaderHide");
        });
    },
    initiateChat() {
      this.$store.commit("loaderShow");
      API(this, `rest/start-chat/${this.singleOrderID}`, "post", null)
        .then((res) => {
          this.$store.commit("loaderHide");
          // this.record?.chat_rider_started_from_rest=true;
          setTimeout(() => {
            const element = document.getElementById("ChatBox");
            element.scrollIntoView({ behavior: "smooth" });
          }, 500);
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: view-single-order.vue ~ initiateChat ~ err",
            err
          );
          this.$store.commit("loaderHide");
        });
    },
    getQuestions() {
      if (!this.cancelQuestions.length) {
        this.questionsLoading = true;
        API(this, "rest/get-active-cancel-questions", "get")
          .then((res) => {
            this.cancelQuestions = res.data.response.detail.cancel_questions;
            this.questionsLoading = false;
          })
          .catch((err) => {
            console.error(
              "🚀 ~ file: single-order.vue ~ getQuestions ~ err",
              err
            );
            this.questionsLoading = false;
          });
      }
    },
    handleQuestionRd(value) {
      this.cancelOrderForm.order_cancel_question_id =
        value.order_cancel_question_id;
      this.cancelOrderForm.order_cancel_question = value.title;
    },
    cancelOrder() {
      if (!this.cancelOrderForm.order_cancel_question_id) {
        this.$store.dispatch("WarningToast", {
          message: "Please select one options",
        });
      } else {
        this.$store.commit("loaderShow");
        this.$refs.close_myModal2.click();
        API(
          this,
          `rest/cancel-order/${this.record?.order_id}`,
          "post",
          this.cancelOrderForm
        )
          .then((res) => {
            this.getRecord();
            this.$store.dispatch("SuccessToast", {
              message: res.data.response.message,
            });
            this.$store.commit("loaderHide");
          })
          .catch((err) => {
            console.error("🚀 ~ file: show-orders.vue ~ getRecords ~ err", err);
            this.$store.dispatch("WarningToast", {
              message: "Something went wrong. Please try again.",
            });
            this.$store.commit("loaderHide");
          });
      }
    },
    getRatingQuestions() {
      if (!this.ratingQuestions.length) {
        this.questionsLoading = true;
        API(this, "rest/rider-rating-active-questions", "get")
          .then((res) => {
            let data = res?.data?.response?.detail;
            data.forEach((x) => {
              this.ratingQuestions.push({
                id: x.rider_rating_question_id,
                rating: 1,
                question: x.text,
              });
            });
            this.questionsLoading = false;
          })
          .catch((err) => {
            console.error(
              "🚀 ~ file: single-order.vue ~ getRatingQuestions ~ err",
              err
            );
            this.questionsLoading = false;
          });
      }
    },
    getRating(id, stars) {
      let objIndex = this.ratingQuestions.findIndex((x) => x.id == id);
      this.ratingQuestions[objIndex].rating = stars;
    },
    feedbackRider() {
      this.$store.commit("loaderShow");
      this.$refs.close_myModal3.click();
      let fd = new FormData();
      fd.append("comment", this.feedbackcomment);
      this.ratingQuestions.forEach((x, i) => {
        fd.append(`question[${i}][text]`, x.question);
        fd.append(`question[${i}][rating]`, x.rating);
      });
      API(
        this,
        `rest/store-order-rider-question-rating/${this.singleOrderID}`,
        "post",
        fd
      )
        .then((res) => {
          this.record.rider_rated = true;
          this.$store.dispatch("SuccessToast", {
            message: res.data.response.message,
          });
          this.$store.commit("loaderHide");
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: single-order.vue ~ feedbackRider ~ err",
            err
          );
          this.$store.dispatch("WarningToast", {
            message: "Something went wrong. Please try again.",
          });
          this.$store.commit("loaderHide");
        });
    },
  },
};
</script>
  
<style scoped>
.table_3302s td p {
  font-size: clamp(0.785rem, 1.5vw, 1rem);
}
</style>
  