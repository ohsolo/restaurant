<template>
  <div class="card shadow w-25 border-0 text-end mx-2 ms-0 mt-4 p-4">
    <h4 class="m_0">{{ num??'-' }}</h4>
    <small class="text-secondary">{{ title?$t(title):'-' }}</small>
  </div>
</template>

<script>
export default {
  name: "CustomCard",
  props: {
    num: String,
    title: String,
  },
};
</script>

<style>
</style>