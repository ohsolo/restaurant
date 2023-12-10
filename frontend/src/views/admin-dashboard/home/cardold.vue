<template>
  <div class="card px-3 py-4 shadow border-0 pt-4 text-dark overflow-hidden text-end">
    <h4 class="fs-3">{{ num }}</h4>
    <small>{{ title }}</small>
    <div class="text-start mt-4">
        <a href={{url}} class="bg_primary hover_light focus_primary rounded px-2 py-1 d-inline text-light">See Detail</a>
    </div>
  </div>
</template>

<script>
export default {
  name: "CustomCard",
  props: {
    num: String,
    title: String,
    url: String,
  },
};
</script>

<style>
</style>