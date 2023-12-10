<template>
  <form
    class="az_globalForm mt-4"
    autocomplete="off"
    @submit.prevent="handleForm"
  >
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Branch") }}</label>
          <SearchContent
            url="rest/get-branches-by-name?search="
            objKey="branches"
            myKey="location"
            focus
            @my-call-back="myBranches"
          />
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Address") }}</label>
          <SearchContent
            url="rest/get-addresses-by-name?search="
            objKey="addresses"
            myKey="location"
            focus
            @my-call-back="myAddress"
          />
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{
            $t("orderForm.Restaurant_Order_Amount")
          }}</label>
          <div class="p_relative">
            <input
              type="text"
              class="form-control"
              required
              v-model="formData.restaurant_order_amount"
            />
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Order_Method") }}</label>
          <div class="p_relative">
            <select
              class="form-control"
              style="appearance: auto"
              required
              v-model="formData.order_method"
            >
              <option value="">Select Method</option>
              <option value="app">App</option>
              <option value="email">Email</option>
              <option value="phone">Phone</option>
              <option value="whatsapp">Whatsapp</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Payment_Method") }}</label>
          <div class="p_relative">
            <select
              class="form-control"
              style="appearance: auto"
              required
              v-model="formData.payment_method"
            >
              <option value="">Select Method</option>
              <option value="online">Online</option>
              <option value="cash_on_delivery">Cash on delivery</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Output") }}</label>
          <div class="p_relative">
            <input
              type="time"
              class="form-control"
              required
              v-model="formData.output_time"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Dishes_Info") }}</label>
          <div class="p_relative">
            <textarea
              class="form-control"
              id=""
              rows="3"
              required
              v-model="formData.dishes_info"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Observations") }}</label>
          <div class="p_relative">
            <textarea
              class="form-control"
              id=""
              rows="3"
              required
              v-model="formData.observations"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Remarks") }}</label>
          <div class="p_relative">
            <textarea
              class="form-control"
              id=""
              rows="3"
              required
              v-model="formData.remarks"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Compliments") }}</label>
          <div class="p_relative">
            <textarea
              class="form-control"
              id=""
              rows="3"
              required
              v-model="formData.compliments"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Comments") }}</label>
          <div class="p_relative">
            <textarea
              class="form-control"
              id=""
              rows="3"
              required
              v-model="formData.comments"
            ></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <h5 class="fw-bold t_primary">{{ $t("orderForm.Customer_Info") }}</h5>
      </div>
      <div class="col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">Name</label>
          <div class="p_relative">
            <input
              type="text"
              class="form-control"
              required
              v-model="formData.customer_name"
            />
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xs-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Phone_Number") }}</label>
          <div class="p_relative">
            <input
              type="text"
              class="form-control"
              required
              v-model="formData.customer_phone"
            />
          </div>
        </div>
      </div>
      <div class="col-12 mb-4">
        <div class="input_wrapper">
          <label class="mb-2">{{ $t("orderForm.Other_Info") }}</label>
          <div class="p_relative">
            <textarea
              class="form-control"
              id=""
              rows="3"
              v-model="formData.customer_other_info"
            ></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <input
          type="submit"
          class="
            btn
            bg_primary
            focus_primary
            hover_light
            text-light
            d-block
            mt-5
            mx-auto
          "
          :value="$t('submitBtn')"
          style="width: 100%; max-width: 150px; font-weight: 600"
        />
      </div>
    </div>
  </form>
</template>
  
<script>
import SearchContent from "../../../components/admin-components/search-content/index.vue";
import { API } from "../../../axois";
export default {
  name: "AddOrder",
  components: { SearchContent },
  data() {
    return {
      formData: {
        branch_id: "",
        address_id: "",
        restaurant_order_amount: "",
        order_method: "",
        output_time: "",
        customer_name: "",
        customer_phone: "",
        customer_other_info: "",
        payment_method: "",
        dishes_info: "",
        observations: "",
        remarks: "",
        compliments: "",
        comments: "",
        response: "lorem",
      },
      message: null,
    };
  },
  created() {},
  methods: {
    handleForm() {
      if (this.formValidate()) {
        this.$store.dispatch("WarningToast", {
          message: this.message,
        });
        return;
      } else {
        this.$store.commit("loaderShow");
        API(this, "admin/order", "post", this.formData)
          .then((response) => {
            this.$store.commit("loaderHide");
            this.$store.dispatch("SuccessToast", {
              message: response.data.response.message,
            });
            this.$emit("handle-screen", "SHOW_ORDERS");
          })
          .catch((err) => {
            console.error("🚀 ~ file: add-orders.vue ~ handleForm ~ err", err);
            this.$store.commit("loaderHide");
          });
      }
    },
    myBranches(item) {
      if (item == "") {
        this.formData.branch_id = "";
      }
      this.formData.branch_id = item.branch_id;
    },
    myAddress(item) {
      if (item == "") {
        this.formData.address_id = "";
      }
      this.formData.address_id = item.address_id;
    },
    formValidate() {
      let flag = true;

      let {
        branch_id,
        address_id,
        // customer_info,
        restaurant_order_amount,
        order_method,
        output_time,
        payment_method,
        customer_name,
        customer_phone,
        customer_other_info,
        dishes_info,
        observations,
        remarks,
        compliments,
        comments,
        response,
      } = this.formData;
      if (
        !branch_id ||
        !address_id ||
        // !customer_info ||
        !restaurant_order_amount ||
        !order_method ||
        !observations ||
        !remarks ||
        !response ||
        !customer_name ||
        !customer_phone ||
        !customer_other_info ||
        !payment_method ||
        !output_time ||
        !dishes_info ||
        !comments ||
        !compliments
      ) {
        this.message = "All fields are required";
        console.log(
          "🚀 ~ file: add-order.vue ~ line 214 ~ formValidate ~ formData",
          this.formData
        );
        flag = true;
      } else {
        flag = false;
      }
      return flag;
    },
  },
};
</script>
  
  