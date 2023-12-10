<template>
  <div class="az_search_content">
    <input
      type="text"
      ref="Input"
      :name="myKey"
      :placeholder="givenValue"
      class="form-control"
      :class="focus?'':'focus_none'"
      @input="filterData($event)"
    />
    <div class="search_content" v-if="loader">
      <div class="az_loader"></div>
    </div>
    <div class="search_content" v-if="returnNull">
      <span class="text-center dim d-block">Not Found</span>
    </div>
    <div class="search_content" v-if="returnValue !== ''">
      <button
        type="button"
        class="border-0"
        @click="setValue(data)"
        v-for="data in returnValue"
        :key="data"
      >
        {{ data[myKey] }}
      </button>
    </div>
  </div>
</template>

<script>
import { API } from "../../../axois";
export default {
  name: "SearchContent2",
  props: {
    url: {
      type: String,
    },
    myKey: {
      type: String,
    },
    objKey: {
      type: String,
    },
    focus: {
      type: Boolean,
    },
    givenValue: {
      type: String,
    },
  },
  data() {
    return {
      returnValue: "",
      loader: false,
      returnNull: false,
    };
  },
  methods: {
    setValue(item) {
      this.returnValue = "";
      this.$refs.Input.value = item[this.myKey];
      this.$emit("my-call-back", item);
    },
    filterData(event) {
      let value = event.target.value;
      let find = value.toLowerCase();
      if (value.length < 3) {
        this.returnValue = "";
        this.returnNull = false;
        return;
      }
      this.loader = true;
      API(this, this.url + find, "get", null)
        .then((response) => {
          this.loader = false;
          let res = response.data.response.detail;
          this.returnValue=res[this.objKey]
        })
        .catch((err) => {
          this.loader = false;
          this.returnValue = "";
          this.returnNull = true;
        });
    },
  },
};
</script>
