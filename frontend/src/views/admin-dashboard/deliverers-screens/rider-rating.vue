<template>
  <div class="az_awaiting_approval">
    <section class="az_filterable_table">
      <div class="container-fluid">
        <div class="az_rider_ranking">
          <div class="row">
            <div class="col-12">
              <div class="rider_profile">
                <div class="profile_wrapper">
                  <div class="img_wrapper">
                    <img :src="records?.rider?.profile_image_url" class="img_fluid" />
                  </div>
                  <h2 class="t_primary ms-2 mb-0">
                    {{ records?.rider?.name }}
                  </h2>
                </div>
                <div>
                  <h4 class="mb-0">
                    Total Rating
                    <span class="text-warning">{{
                    records?.rider?.total_rating
                    }}</span>
                  </h4>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="rating_wrapper" v-for="data in records?.rider_ratings?.data" :key="data.id">
                <div class="card mb-3">
                  <div class="az_left">
                    <div class="img_wrapper">
                      <img :src="null" alt="" class="img_fluid" />
                    </div>
                  </div>
                  <div class="az_right">
                    <div class="head">
                      <div>
                        <h5 class="fw-bold mb-0">
                          Order&nbsp;#&nbsp;<span>{{
                          data.order.order_number
                          }}</span>
                        </h5>
                        <span class="mb-0">
                          {{ data.order.created_at.slice(0, 10) }}</span>
                      </div>
                      <h2 class="text-warning">{{ data.rating }}</h2>
                    </div>
                    <div class="content">
                      <div class="
                          d-flex
                          justify-content-between
                          align-center
                          flex-wrap
                          w-100
                          mb-2
                        ">
                        <small>Punctuality</small>
                        <div>
                          <fa icon="star" v-for="n in 5" :key="n" :class="{
                            checked: n <= data.rating,
                            null: n > data.rating,
                          }" />
                        </div>
                      </div>
                      <div class="
                          d-flex
                          justify-content-between
                          align-center
                          flex-wrap
                          w-100
                          mb-2
                        ">
                        <small>Education</small>
                        <div>
                          <fa icon="star" v-for="n in 5" :key="n" :class="{
                            checked: n <= data.rating,
                            null: n > data.rating,
                          }" />
                        </div>
                      </div>
                      <div class="
                          d-flex
                          justify-content-between
                          align-center
                          flex-wrap
                          w-100
                          mb-2
                        ">
                        <small>Hygiene</small>
                        <div>
                          <fa icon="star" v-for="n in 5" :key="n" :class="{
                            checked: n <= data.rating,
                            null: n > data.rating,
                          }" />
                        </div>
                      </div>
                    </div>
                    <div class="foo">
                      <h6 class="fw-bold mb-0">Comment</h6>
                      <p>{{ data.comment }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import { API } from "../../../axois.js";
import Pagination from "v-pagination-3";
export default {
  name: "RiderRanking",
  title: "Ranking And Evaluation | Dashbaord",
  components: { Pagination },
  data() {
    return {
      page: 1,
      records: [],
      star: 0,
    };
  },
  mounted() { },
  created() {
    this.getRecords();
  },
  methods: {
    getRecords() {
      this.$store.commit("loaderShow");
      API(
        this,
        "admin/get-single-rider-ratings/" + this.$route.params.id,
        "get"
      )
        .then((response) => {
          const Data = response.data.response.detail;
          this.records = Data;
          this.records?.rider_ratings?.data?.map(
            (item) => (this.star = item?.rating)
          );
          this.$store.commit("loaderHide");
        })
        .catch((error) => {
          console.error("🚀 ~ file: rider-rating.vue ~ getRecords ~ error", error)
          this.$store.commit("loaderHide");
        });
    },
    paginationCallback(value) {
      this.page = value;
      this.getRecords();
    },
  },
};
</script>
