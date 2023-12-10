<template>
  <div className="star_rating247">
    <template v-for="index in 5" :key="index">
      <button
        type="button"
        className="border-0"
        style="background-color: #fff"
        @click="() => handleChange(index)"
        @mouseover="() => handleOver(index)"
        @mouseleave="handleLeave"
      >
        <fa
          :style="[
            index <= (hover || stars)
              ? { color: '#F4B64A' }
              : { color: '#ccc' },
          ]"
          icon="star"
        />
      </button>
    </template>
  </div>
</template>
        
<script>
export default {
  name: "StarRating",
  props: {
    id:{
      type:String
    },
    rating:{
      type:Number
    }
  },
  data() {
    return {
      stars: 1,
      hover: 1,
    };
  },
  created() {
    this.stars=this.rating;
    this.hover=this.rating;
  },
  methods: {
    handleChange(index) {
      this.stars=index;
      this.$emit('get-rating',this.id,index);
    },
    handleOver(index) {
      this.hover=index;
    },
    handleLeave() {
      this.hover=this.stars;
    },
  },
};
</script>
    
<style scoped>
</style>
    