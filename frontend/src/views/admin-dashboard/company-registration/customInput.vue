<template>
  <div class="input_wrapper">
    <label class="mb-2" v-if="label.length">{{label}}</label>
    <div class="p_relative">
      <input
        :type="type"
        class="form-control"
        name=''
        :required="required == true"
        v-model="value"
        @change='$emit("custom-input-change",$event.target.value,index)'
      />
      <span class="error" v-if="hasError.length">
          {{hasError}}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "CustomInput",
  props: {
    label: {
      type: String,
      required: false,
    },
    type: {
      type: String,
      required: true,
    },
    value: {
      type: String,
      required: true,
    },
    required: {
      type: Boolean,
      required: true,
    },
    hasError:{
      type: Boolean,
      required: false,
    },
    index:{
      type: Number,
      required: true,
    }
  },
};
</script>

<style>
</style>